<h1>Crear nueva categoria</h1>


<form action="<?=$_ENV['base_url']?>categoria/saveCategoria" method="post">

<label for="nombre">Nombre</label>
<input type="text" name="nombre" required>

<input type="submit" value="Crear categoría">

</form>

