<?php $this->load->view('template/detalle-corto'); 
  if(isset($estadisticas)){
 	$this->load->view('template/hits'); 
  }else{
      echo 'no hay estadisticas';
  }
  if(isset($estadisticas_clicks)){
  	$this->load->view('template/clicks');
  }else{
      echo 'no hay estadisticas';
  }
?>