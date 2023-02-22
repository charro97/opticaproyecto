<h1>Borrar producto</h1>


<form id="producto_new" action="<?=$_ENV['base_url']?>producto/borrar" method="post" enctype='multipart/form-data'>
<label for="producto_id">Id del producto</label>
<select name="producto_id" id="producto_id">
    <?php while($prod = $productos->fetch(PDO::FETCH_OBJ)): ?>
    <option value="<?= $prod->id ?>" >
        <?= $prod->nombre?>
    </option>
    <?php endwhile; ?>
</select>


<input type="submit" value="Eliminar">


</form>