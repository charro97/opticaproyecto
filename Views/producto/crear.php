<h1>Crear nuevo producto</h1>


<form id="producto_new" action="<?=$_ENV['base_url']?>producto/save" method="post" enctype='multipart/form-data'>

<label for="nombre">Nombre</label>
<input id="nombre" type="text" name="nombre" required>
<label for="descripcion">Descripción</label>
<textarea id="descripcion" name="descripcion"cols="30" rows="10"></textarea>
<label for="precio">Precio</label>
<input type="number" name="precio" id="precio" step="0.01" required>
<label for="stock">Stock</label>
<input type="number" name="stock" id="stock" required>
<label for="categoria_id">Id de categoria</label>
<select name="categoria_id" id="categoria_id">
    <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)): ?>
    <option value="<?= $cat->id ?>" >
        <?= $cat->nombre?>
    </option>
    <?php endwhile; ?>
</select>

<label for="imagen">Imagen</label>
<input type="file" name="imagen" id="imagen">

<input type="submit" value="Crear">


</form>


