<?php use Utils\Utils;?>

<?php if(isset($_SESSION['admin'])): ?>
    <li id="crear"><a href="<?=$_ENV['base_url']?>producto/crear">Crear producto</a></li><br><br>
    <li id="borrar"><a href="<?=$_ENV['base_url']?>producto/borrar">Borrar producto</a></li><br><br>
<?php endif; ?>


<br><br>


<?php if(isset($_SESSION['admin']) && isset($_SESSION['crear_producto'])): ?>

<?php if($_SESSION['crear_producto'] === 'complete' ): ?>
    <p>Producto guardado correctamente</p>
    <?php elseif($_SESSION['crear_producto'] === 'failed' ): ?>
    <p>No se ha podido guardar el producto</p>
    <?php endif; ?>

<?php endif; ?>


<?php if(isset($_SESSION['admin']) && isset($_SESSION['borrar_producto'])): ?>

<?php if($_SESSION['borrar_producto'] === 'complete' ): ?>
    <p>Producto eliminado correctamente</p>
    <?php elseif($_SESSION['borrar_producto'] === 'failed' ): ?>
    <p>No se ha podido eliminar el producto</p>
    <?php endif; ?>

<?php endif; ?>


<?php if(isset($_SESSION['errores_prod'])): ?>
    <h3>¡Atención!</h3>
    
    <?php foreach($_SESSION['errores_prod'] as $error){
        echo $error . "<br>";
    }
        ?>
<?php endif; ?>
<?php Utils::deleteSession('errores_prod'); ?>


<h1>Productos</h1>
<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
        <th>PRECIO</th>
        <th>STOCK</th>
        
    </tr>
    <?php while($prod = $productos->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?=$prod->id;?></td>
            <td><?=$prod->nombre;?></td>
            <td><?=$prod->precio;?></td>
            <td><?=$prod->stock;?></td>
        </tr>
    <?php endwhile; ?>

</table>

<?php

if (isset($_SESSION['crear_producto'])) {
    unset($_SESSION['crear_producto']);
}

if (isset($_SESSION['borrar_producto'])) {
    unset($_SESSION['borrar_producto']);
}

?>