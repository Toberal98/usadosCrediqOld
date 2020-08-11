







<?php if (time() > mktime(0, 0, 0, 5, 1, 2017) && time() < mktime(0, 0, 0, 5, 8, 2017)): ?>
  <script>
    $(function () {
      $.fancybox.open('/public/images/feria-usados.jpg');
    });
  </script>
<?php endif; ?>


<div class="content">
    <div class="container12">
        <div class="row">
            <div class="column12">
                <h3 class="clearfix"><a href="#" class="filters-open"><em class="fa fa-filter"></em></a>Busca tu usado ideal<span></span></h3>
            </div>
        </div>


        <div class="row">

            <?php
            if (isset($filtro)) {

                $this->load->view('template/filtro.php');
            }
?>
            <div id="box">
            <?php
            if (isset($vista1)) {
                $this->load->view('template/ajax/ver_bloques.php');
            }
            if (isset($vista2)) {
                $this->load->view('template/ajax/ver_lista.php');
            }
            ?>

        </div>
    </div>
</div>

<?php

if(!$this->session->userdata('mostrar_banner')=="false"){
    $this->load->view('template/banner-principal.php');
}
?>
