
<form id="form1" name="form1" method="post" action="">
  <label for="buscar">Buscar</label>
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>


cant. vehiculos
<table width="100%" border="1px" id="hor-minimalist-a">
  <tr>
    <th >usuario</th>
    <th >fecha ingreso</th>
    <th >cant. vehiculos</th>
    <th >Acciones</th>
  </tr>

  <?php
  if(isset($adverts)){ foreach ($adverts as $advert) : ?>
  <tr>
    <td ><?php echo $advert['nombre']; ?></td>
    <td ><?php echo $advert['posicion']; ?></td>
    <td ><?php echo $advert['hits']; ?></td>
    <td ><a href="<?php echo base_url() ?>index.php/site/advert_update/<?php echo $advert['id_banner'] ?>">Marcar como primium</a></td>
  </tr>
  <?php endforeach; } ?>
</table>
<?php 
if(isset($pagination)){

  echo $pagination;
}
?>
