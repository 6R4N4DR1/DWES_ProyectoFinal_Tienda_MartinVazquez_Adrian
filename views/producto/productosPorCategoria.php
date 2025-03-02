<h1>Productos de la categoría: <?=$categoriasMap[$_GET['id']]?></h1>

<?php if(count($productos) > 0): ?>
    <!-- Contenedor de productos por categoría -->
    <div class="productos">
        <?php foreach($productos as $producto): ?>
            <!-- Producto -->
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

    <!-- Paginación -->
    <div class="paginacion">
        <?php if($paginaActual > 1): ?>
            <!-- Enlace a la página anterior -->
            <a href="<?=BASE_URL?>producto/productosPorCategoria&id=<?=$_GET['id']?>&pagina=<?=($paginaActual - 1)?>" class="boton">Anterior</a>
        <?php endif; ?>

        <?php for($i = 1; $i <= $totalPaginas; $i++): ?>
            <!-- Enlaces a las páginas de la paginación -->
            <a href="<?=BASE_URL?>producto/productosPorCategoria&id=<?=$_GET['id']?>&pagina=<?=$i?>" class="boton <?=($i == $paginaActual) ? 'activo' : ''?>"><?=$i?></a>
        <?php endfor; ?>

        <?php if($paginaActual < $totalPaginas): ?>
            <!-- Enlace a la página siguiente -->
            <a href="<?=BASE_URL?>producto/productosPorCategoria&id=<?=$_GET['id']?>&pagina=<?=($paginaActual + 1)?>" class="boton">Siguiente</a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <!-- Mensaje de error si no hay productos registrados -->
    <strong class="error">No hay productos registrados en esta categoría</strong>
<?php endif; ?>