<?php
use Models\Categoria;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://localhost/opticaproyecto/public/css/styles.css">
    <title>Óptica Buenavista</title>
</head>
<body>
<header>

<div id="logo">
    <h1><a href="<?=$_ENV['base_url']?>">Óptica Buenavista</a></h1>
</div>


<?php if(isset($_SESSION['identity'])): ?>
            <h3>Bienvenido <?=$_SESSION['identity']->nombre?> <?=$_SESSION['identity']->apellidos?> </h3>
        <?php endif; ?>

<nav id="menu_grande">
    <ul>

        <?php if(isset($_SESSION['identity'])): ?>
            <li><a href="<?=$_ENV['base_url']?>pedido/mis_pedidos">Mis pedidos</a></li>
        <?php endif; ?>
        
    
    
        <?php if(isset($_SESSION['admin'])): ?>
            <li><a href="<?=$_ENV['base_url']?>categoria/index">Gestionar categorías </a></li>
            <li><a href="<?=$_ENV['base_url']?>producto/gestion">Gestionar productos </a></li>
        
        <?php endif; ?>

        

        <?php if(!isset($_SESSION['identity'])): ?>
            <li><a href="<?=$_ENV['base_url']?>usuario/registro">Crear cuenta</a></li>
            <li><a href="<?=$_ENV['base_url']?>usuario/identifica">Login</a></li>
                
        <?php endif; ?>

        <li><a href="<?=$_ENV['base_url']?>carrito/index">Cesta</a></li>

        <?php if(isset($_SESSION['identity'])): ?>
            <li><a href="<?=$_ENV['base_url']?>usuario/logout">Cerrar Sesión</a></li>
        <?php endif; ?>
    </ul>
    <nav>


    <?php  $categorias = Categoria::obtenerCategorias(); ?>

    <nav id="menu_cat">
        <ul>
            <?php while($cat = $categorias->fetch(PDO::FETCH_OBJ)):?>
            <li><a href="<?=$_ENV['base_url']?>categoria/ver/<?=$cat->id?>"><?=$cat->nombre?></a></li>
                <?php endwhile ?>
        </ul>
    </nav>

    </nav>

                 
</nav>

                 
</nav>



</header>