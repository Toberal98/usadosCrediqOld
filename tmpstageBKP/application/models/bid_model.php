<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Bid_model extends CI_Model
{

    public function carAllowsBids($car_id, $amount)
    {
        $car = $this->getCar($car_id);

        $this->db->where('car_id =', $car_id);
        $this->db->where('status =', 1);

        $query = $this->db->get('cq_car_bids');
        $has_winner_bid = $query->num_rows() > 0;

        return $car && !$has_winner_bid ? ((int) $car->precio < (int) $amount) : -1;
    }

    public function create($user_id, $car_id, $amount)
    {
        $created_at = date('Y-m-d H:i:s');
        $data       = compact('user_id', 'car_id', 'amount', 'created_at');
        $this->db->insert('cq_car_bids', $data);
        return $this->getBid($this->db->insert_id());
    }

    public function getBidsForCar($car_id)
    {
        $this->db->select('b.amount, b.created_at, b.id, b.status, u.*');
        $this->db->from('cq_car_bids b');
        $this->db->join('cq_usuario u', 'b.user_id = u.id_usuario');
        $this->db->where('b.car_id =', $car_id);

        $query = $this->db->get();
        return $query->result();
    }

    public function getBid($bid_id, $related = false)
    {
        $this->db->where('id =', $bid_id);

        $query = $this->db->get('cq_car_bids');
        $bid   = $query->result();
        $bid   = isset($bid[0]) ? $bid[0] : null;

        if ($bid && $related) {
            $bid->car  = $this->getCar($bid->car_id, false, true);
            $bid->user = $this->getUser($bid->user_id);
        }

        return $bid;
    }

    protected function getCar($car_id, $available = true, $owner = false)
    {
        $this->db->where('id_automovil =', $car_id);
        $this->db->where('tipo_venta =', '3');

        if ($available) {
            $this->db->where('bid_available_until IS NOT NULL');
            $this->db->where('bid_available_until >=', date('Y-m-d H:i:s'));
        }

        $query = $this->db->get('cq_automovil', 1);
        $car   = $query->result();
        $car   = isset($car[0]) ? $car[0] : null;

        if ($car && $owner) {
            $car->owner = $this->getUser($car->usuario);
            $car->brand = $this->getBrand($car->marca);
            $car->model = $this->getModel($car->modelo);
        }

        return $car;
    }

    protected function getUser($user_id)
    {
        $this->db->where('id_usuario =', $user_id);
        $query = $this->db->get('cq_usuario', 1);
        $user  = $query->result();
        return isset($user[0]) ? $user[0] : null;
    }

    protected function getBrand($brand_id)
    {
        $this->db->where('id_marca =', $brand_id);
        $query = $this->db->get('cq_marca', 1);
        $brand = $query->result();
        return isset($brand[0]) ? $brand[0] : null;
    }

    protected function getModel($model_id)
    {
        $this->db->where('id_modelo =', $model_id);
        $query = $this->db->get('cq_modelo', 1);
        $model = $query->result();
        return isset($model[0]) ? $model[0] : null;
    }

    public function markAsWinner($bid_id)
    {
        $bid = $this->getBid($bid_id);

        $this->db->where('car_id =', $bid->car_id);

        $this->db->update('cq_car_bids', [
            'status' => 0,
        ]);

        $this->db->where('id =', $bid_id);

        return $this->db->update('cq_car_bids', [
            'status' => 1,
        ]);
    }

    public function isMyCar($user_id, $car_id)
    {
        $this->db->where('id_automovil =', $car_id);
        $this->db->where('usuario =', $user_id);

        $query = $this->db->get('cq_automovil', 1);

        return $query->num_rows() > 0;
    }

}
