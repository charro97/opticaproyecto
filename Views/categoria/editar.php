<h1>Editar categoría</h1>


<form id="producto_new" action="<?=$_ENV['base_url']?>categoria/actualizar" method="post" enctype='multipart/form-data'>
<label for="categoria_id">Id de categoria</label>
<select name="categoria_id" id="categoria_id">
    <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
    <option value="<?= $cat->id ?>" >
        <?= $cat->nombre?>
    </option>
    <?php endwhile; ?>
</select>

<label for="nombre">Nuevo nombre de la categoría</label>
<input id="nombre" type="text" name="nombre" required>


<input type="submit" value="Actualizar">


</form>