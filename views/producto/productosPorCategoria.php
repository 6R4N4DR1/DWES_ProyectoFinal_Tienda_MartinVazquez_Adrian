<h1>Productos de la categoría: <?=$categoriasMap[$_GET['id']]?></h1>

<?php if(count($productos) > 0): ?>
    <!-- Contenedor de productos por categoría -->
    <div class="productos">
        <?php foreach($productos as $producto): ?>
            <!-- Producto -->
            <div class="producto">
                <!-- Imagen del producto -->
                <?php if($producto->getImagen()): ?>
                    <img src="<?=BASE_URL?>assets/images/<?=$producto->getImagen();?>" alt="<?=$producto->getNombre();?>">
                <?php else: ?>
                    <img src="<?=BASE_URL?>assets/images/default.png" alt="<?=$producto->getNombre();?>">
                <?php endif; ?>
                <!-- Nombre del producto -->
                <h2><?=$producto->getNombre();?></h2>
                <!-- Descripción del producto -->
                <p><?=$producto->getDescripcion();?></p>
                <!-- Precio del producto -->
                <p><?=$producto->getPrecio();?>€</p>
                <!-- Enlace para comprar el producto -->
                <a href="#">Comprar</a>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Mensaje de error si no hay productos registrados -->
    <strong class="error">No hay productos registrados en esta categoría</strong>
<?php endif; ?>