<?php if(isset($product)): ?>
    <h3><?= $product->nombre ?></h3>
    <div>
        <div>
            <?php if ($product->imagen != NULL): ?>
                <img src="<?= $_ENV['base_url'] ?>uploads/images/<?= $product->imagen ?>" >
            <?php else: ?>
                <img src="<?= $_ENV['base_url'] ?>assets/img/grafic.png" >
            <?php endif; ?>  
        </div>
        <div>
            <p><?= $product->descripcion ?></p>
            <p><?= $product->precio ?>$</p>
            <p class="comprar"><a href="<?= $_ENV['base_url'] ?>carrito/add/<?= $product->id ?>">Comprar</a></p>
        </div>
    </div>
<?php else: ?>
    <h1>El producto no existe</h1>
<?php endif; ?>