<?php namespace Utils;?>


<h1>Nuevo pedido</h1>
<h2>Rellena los datos solicitados:</h2>

<?php $cuenta = Utils::cuentaCarrito(); ?>

<form id="pedido_new" action="<?=$_ENV['base_url']?>pedido/hacer" method="post" enctype='multipart/form-data'>

<label for="provincia">Provincia</label>
<input id="provincia" type="text" name="provincia" required>
<label for="localidad">Localidad</label>
<input id="localidad" type="text" name="localidad" required>
<label for="direccion">Direccion</label>
<input id="direccion" type="text" name="direccion" required>
<input type="submit" value="Confirmar pedido">
</form>

<h3>Precio total del pedido: <?= $cuenta ?>$</h3>
