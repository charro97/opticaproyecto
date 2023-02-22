<?php if(!isset($_SESSION['identity'])): ?>

<h1>Login</h1>
<form action="<?=$_ENV['base_url']?>usuario/login" method="POST">
    <label for="email">Email</label>
    <input type="email" name="data[email]" />
    <label for="password">Password</label>
    <input type="password" name="data[password]" />
    <input type="submit" value="Enviar">
</form>


<?php else: ?>
    <h3><?=$_SESSION['identity']->nombre ?> <?=$_SESSION['identity']->apellidos ?></h3>
<?php endif; ?>