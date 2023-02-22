

<?php if (false): ?>
    <p>No hay productos para mostrar</p>

<?php else: ?>
    <div class="productos">
    <?php while ($product = $productos->fetch(PDO::FETCH_OBJ)): ?>
        <div class="product">
            <a href="<?= $_ENV['base_url'] ?>producto/ver/<?= $product->id ?>">
                <?php if ($product->imagen != NULL): ?>
                    <img src="<?= $_ENV['base_url'] ?>uploads/images/<?= $product->imagen ?>" >
                <?php else: ?>
                    <img src="<?= $_ENV['base_url'] ?>assets/img/grafic.png" >
                    <?php endif; ?>
                <h4><?= $product->nombre ?></h4>
            </a>
            <p><?= $product->precio ?>$</p>
            <p class="comprar"><a href="<?= $_ENV['base_url'] ?>carrito/add/<?= $product->id ?>">Comprar</a></p>
        </div>
    <?php endwhile; ?>
    </div> 
<?php endif; ?>