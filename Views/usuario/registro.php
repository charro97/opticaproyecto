<h1>Crear cuenta nueva</h1>
<?php use Utils\Utils;?>


<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <strong class="alert_green">Registro completado correctamente</strong>

    <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
    <strong class="alert_red">Registro fallido</strong>

    <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'exist'): ?>
    <strong class="alert_red">El email ya existe</strong>

<?php endif; ?>
<?php Utils::deleteSession('register'); ?>



<form action="<?=$_ENV['base_url']?>usuario/registro" method="POST">
    <label for="nombre">Nombre</label>
    <input type="text" name="data[nombre]" required /><br>

    <label for="apellidos">Apellidos</label>
    <input type="text" name="data[apellidos]" required /><br>

    <label for="email">Email</label>
    <input type="email" name="data[email]" required /><br>

    <label for="password">Contraseña</label>
    <input type="password" name="data[password]" required /><br>

    <input type="submit" value="Registrarse">
 

</form>


<?php if(isset($_SESSION['errores'])): ?>
    <h3>¡Atención!</h3>
    
    <?php foreach($_SESSION['errores'] as $error){
        echo $error . "<br>";
    }
        ?>
<?php endif; ?>
<?php Utils::deleteSession('errores'); ?>