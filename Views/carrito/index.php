<?php namespace Utils; ?>

<h1>Carrito</h1>


<?php if(isset($_SESSION['carrito'])): ?>
<table class="tCarrito" border="1">
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Precio</th>
            <th>Unidades</th>
            <th>Eliminar</th>
        </tr>
        
        <?php foreach($_SESSION['carrito'] as $indice => $elemento ): ?>
        
        <tr>
            <td>
            <?php $producto = $elemento['producto'];?>
            <?php if ($producto->imagen != NULL): ?>
                <img src="<?= $_ENV['base_url'] ?>uploads/images/<?= $producto->imagen ?>" >
            <?php else: ?>
                <img src="<?= $_ENV['base_url'] ?>assets/img/grafic.png" >
            <?php endif; ?>  
            </td>
            <td>
                <?= $producto->nombre ?>
            </td>
            <td>
                <?= $producto->precio ?>$
            </td>
            <td>
                <?= $elemento['unidades']?>
                <div class="unidades">
                    <a href="<?=$_ENV['base_url']?>carrito/up/<?=$indice?>">+</a>
                    <a href="<?=$_ENV['base_url']?>carrito/down/<?=$indice?>">-</a>
                </div>
            </td>
            <td>
            <a href="<?=$_ENV['base_url']?>carrito/delete/<?=$indice?>" class="boton_eliminar">Quitar producto</a>
            </td>
        </tr>
        <?php endforeach; ?>
</table>
<br>
<div>
<a href="<?=$_ENV['base_url']?>carrito/delete_all" class="boton_vaciar">Vaciar carrito</a>
</div>
<div class="total">
    <?php $cuenta = Utils::cuentaCarrito(); ?>
    <h3>Precio total: <?= $cuenta ?>$</h3>
    <p><a href="<?=$_ENV['base_url']?>pedido/rellenar" class="boton_hacer">Hacer pedido</a></p>
</div>

<?php else: ?>
    <h1>El carrito está vacio</h1>
<?php endif; ?>
