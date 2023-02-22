<?php use Utils\Utils;?>

<?php if(isset($_SESSION['admin'])): ?>
    <li id="crear"><a href="<?=$_ENV['base_url']?>categoria/crear">Crear categoria</a></li><br><br>
    <li id="editar"><a href="<?=$_ENV['base_url']?>categoria/editar">Editar categoria</a></li><br><br>
    <li id="borrar"><a href="<?=$_ENV['base_url']?>categoria/borrar">Borrar categoria</a></li><br><br>
<?php endif; ?>



<?php if(isset($_SESSION['admin']) && isset($_SESSION['crear_categoria'])): ?>

<?php if($_SESSION['crear_categoria'] === 'complete' ): ?>
    <p>Categoría creada correctamente</p>
    <?php elseif($_SESSION['crear_categoria'] === 'failed' ): ?>
    <p>No se ha podido crear la categoría</p>
    <?php endif; ?>

<?php endif; ?>


<?php if(isset($_SESSION['admin']) && isset($_SESSION['actualizar_categoria'])): ?>

<?php if($_SESSION['actualizar_categoria'] === 'complete' ): ?>
    <p>Categoría actualizada correctamente</p>
    <?php elseif($_SESSION['actualizar_categoria'] === 'failed' ): ?>
    <p>No se ha podido actualizar la categoría</p>
    <?php endif; ?>

<?php endif; ?>

<?php if(isset($_SESSION['admin']) && isset($_SESSION['borrar_categoria'])): ?>

<?php if($_SESSION['borrar_categoria'] === 'complete' ): ?>
    <p>Categoría eliminada correctamente</p>
    <?php elseif($_SESSION['borrar_categoria'] === 'failed' ): ?>
    <p>No se ha podido eliminar la categoría. Asegúrate de que la categoría seleccionada no tenga productos</p>
    <?php endif; ?>

<?php endif; ?>

<?php if(isset($_SESSION['errores_cat'])): ?>
    <h3>¡Atención!</h3>
    
    <?php foreach($_SESSION['errores_cat'] as $error){
        echo $error . "<br>";
    }
        ?>
<?php endif; ?>
<?php Utils::deleteSession('errores_cat'); ?>


<h1>Categorías</h1>
<table>
    <tr>
        <th>ID</th>
        <th>NOMBRE</th>
    </tr>
    <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
        <tr>
            <td><?=$cat->id;?></td>
            <td><?=$cat->nombre;?></td>
        </tr>
    <?php endwhile; ?>

</table>
<br>



<?php

if (isset($_SESSION['crear_categoria'])) {
unset($_SESSION['crear_categoria']);
}

if (isset($_SESSION['actualizar_categoria'])) {
    unset($_SESSION['actualizar_categoria']);
}

if (isset($_SESSION['borrar_categoria'])) {
    unset($_SESSION['borrar_categoria']);
}

?>








