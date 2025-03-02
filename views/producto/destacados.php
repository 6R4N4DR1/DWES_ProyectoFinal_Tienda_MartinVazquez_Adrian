<h1>Productos destacados</h1>

<!-- Contenedor de productos destacados -->
<div class="productos">
    <?php foreach($productos as $producto): ?>
        <!-- Producto destacado -->
        <div class="producto">
            <!-- Imagen del producto -->
            <?php if($producto->getImagen()): ?>
                <!-- Muestra la imagen del producto si existe -->
                <img src="<?=BASE_URL?>assets/images/<?=$producto->getImagen();?>" alt="<?=$producto->getNombre();?>">
            <?php else: ?>
                <!-- Muestra una imagen por defecto si no existe una imagen del producto -->
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