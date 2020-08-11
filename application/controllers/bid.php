<?php

class Bid extends CI_Controller
{

    protected $user_id;

    protected $user_perfil;

    public function __construct()
    {
        parent::__construct();

        // cargar dependencias
        $this->load->model('bid_model');
        $this->load->library('session');
        $this->load->library('BidNotifier');

        // asignar atributos usados en todas las acciones
        $this->user_id     = $this->session->userdata('user_id');
        $this->user_perfil = $this->session->userdata('user_perfil');
    }

    public function create($car_id)
    {
        $data   = [];
        $amount = $this->input->post('amount');

        if (!$this->user_id && !in_array($this->user_perfil, array(1, 2))) {
            $data['error'] = 'Debes iniciar sesión para usar esta función';
        } else {
            $can_bid = $this->bid_model->carAllowsBids($car_id, $amount);

            switch (true) {
                case $can_bid === true:
                    $data['bid'] = $this->bid_model
                        ->create($this->user_id, $car_id, $amount);
                    $data['success'] = isset($data['bid']->id);
                    break;
                case $can_bid === false:
                    $data['error'] = 'Debes ingresar una oferta mayor a la oferta mínima requerida por este vehículo';
                    break;
                default:
                    $data['error'] = 'No puedes poner una oferta en este vehículo';
                    break;
            }
        }

        $this->respond($data);
    }

    public function winner($bid_id)
    {
        $data = [];
        $bid  = $this->bid_model->getBid($bid_id);

        if ($bid) {
            $mine = $bid && $this->bid_model->isMyCar($this->user_id, $bid->car_id);

            if ($mine || $this->user_perfil == 1) {
                $data['success'] = $this->bid_model->markAsWinner($bid_id);

                if ($data['success']) {
                    $data['notified'] = $this->bidnotifier->notifyWinner($bid_id);
                }
            } else {
                $data['error'] = 'Para marcar una oferta como ganadora, debes haber sido tú la persona que publica el anuncio del vehículo';
            }
        } else {
            $data['error'] = 'Esa oferta no existe';
        }

        $this->respond($data);
    }

    protected function respond($data = [])
    {
        $response = ['success' => false, 'error' => false];

        header('Content-Type: application/json');
        print json_encode(array_merge($response, $data));
    }

}
