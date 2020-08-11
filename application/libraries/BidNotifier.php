<?php

class BidNotifier
{

    public function __construct()
    {
        $this->load->library('email', [
            'protocol'  => 'smtp',
            'smtp_host' => '190.0.230.57',//'correo.crediqinfo.com',
            'smtp_port' => 25,
            'smtp_user' => 'info',
            'smtp_pass' => 'crediq',
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => '\r\n',
        ]);
    }

    public function notifyWinner($bid_id)
    {
        $bid = $this->bid_model->getBid($bid_id, true);
        $monto = '$' . number_format($bid->amount, 2, '.', ',');

        $body = '<table cellspacing="0" callpadding="0"  width="389" height="180" border="0">';
        $body .= "<tr>";
        $body .= "<th>Oferta en vehículo: {$bid->car->brand->nombre} {$bid->car->model->nombre}</th>";
        $body .= "</tr>";
        $body .= "<tr>";
        $body .= '<td align="center">';
        $body .= "<p>Estimado {$bid->user->nombres} {$bid->user->apellidos}, te notificamos que tu oferta de {$monto} ha sido marcada como ganadora.</p>";
        $body .= '</td>';
        $body .= '</tr>';
        $body .= '</table>';

        return $this->send($bid->user->email, 'Tu oferta ha sido la ganadora', $body);
    }

    public function notifyNewBid($bid_id)
    {
        $bid = $this->bid_model->getBid($bid_id, true);
    }

    protected function send($to, $subject, $body)
    {
        $this->email->set_newline("\r\n");
        $this->email->from('info@crediqinfo.com', 'CrediQ');
        $this->email->to($to);
        // $this->email->bcc('ventasusados@crediq.com');
        $this->email->subject($subject);
        $this->email->message($body);
        return $this->email->send();
    }

    /**
     * __get
     *
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers.
     *
     * @param    string
     * @access private
     */
    public function __get($key)
    {
        $CI = &get_instance();
        return $CI->$key;
    }

}
