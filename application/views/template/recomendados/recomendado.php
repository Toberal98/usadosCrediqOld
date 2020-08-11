<?php
$this->load->view('template/inc/header_stripe.php');
?>

<div class="contenth1 content">
    <div class="container12">
        <div class="row">
            <div class="column12">
                <h1>Recomendados<span></span></h1>
                <p>
                  Recomendados Credi Q, una forma rápida de conocer cuales son las opciones de automóviles que sugerimos, para que puedas evaluarlos y solicitar crédito con el que más te convenga.
                </p>
                <p>
                  &nbsp;
                </p>

                <div id="hide" style="height:0px;overflow:hidden;">

                    <label for="year" class="year"> <input type="hide" id="year" readonly /> </label>
                    <div id="slider-range-year" class="slider-range" ></div>

                   <?php
                    if ($this->session->userdata('pais') == 1) {

                		$pais_amount= 1;
                        ?>

                    <label for="hasta" class="amount" > <input type="hide" id="amount" readonly /> </label>
                   <div id="slider-range-amount" class="slider-range"></div>

                    <?php  }
                    elseif ($this->session->userdata('pais') == 2) {

                		$pais_amount= 2;

                     ?>

                    <label for="hasta" class="amountcr"> <input type="hide" id="amountcr" readonly /> </label>
                   <div id="slider-range-amount-cr" class="slider-range"></div>

                    <?php  }
                    elseif ($this->session->userdata('pais') == 3) {

                		$pais_amount= 3;
                     ?>

                   <label for="hasta" class="amounthn" >  <input type="hide" id="amounthn" readonly /> </label>
                   <div id="slider-range-amount-hn" class="slider-range"></div>

                   <?php  }

                     ?>
                  </div>

                <div id="box">
                  <?php
                  $this->load->view('template/recomendados/ver_bloques.php');
                  ?>
                </div>
            </div>
        </div>
    </div>
</div>
