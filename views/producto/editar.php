<?php
    use helpers\Utils;
    use models\Producto;

    // Obtiene los datos del producto a editar por su ID
    $producto = Producto::getProdPorId($_GET['id']);

    // Obtiene todos los productos
    $productos = Producto::getAllProd();

    // Encuentra la posición del producto en la lista
    $posicionProducto = array_search($producto, $productos);

    // Calcula la página en la que se encuentra el producto
    $paginaProducto = ceil(($posicionProducto + 1) / PRODUCTS_PER_PAGE);
?>

<h1>Modificando: <?=$producto->getNombre()?></h1>

<?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'complete'): ?>
    <!-- Mensaje de éxito si la edición se completó -->
    <strong class="completado">Producto modificado con &eacute;xito.</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'undefined'): ?>
    <!-- Mensaje de advertencia si no se modificó nada -->
    <strong class="advertencia">No has modificado nada. ning&uacute;n dato ha sido cambiado.</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed'): ?>
    <!-- Mensaje de error si la edición falló -->
    <strong class="fallido">Fallo encontrado, no se puedo editar los datos del producto. Prueba de nuevo</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>producto/editarProducto&id=<?=$_GET['id']?>" method="POST" enctype="multipart/form-data" class="formulario-producto">
    <!-- Campo para el precio del producto -->
    <label for="precio">Precio</label>
    <input type="text" name="precio" value="<?= isset($_SESSION['form_data']['precio']) ? $_SESSION['form_data']['precio'] : $producto->getPrecio() ?>">
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_precio'): ?>
        <!-- Mensaje de error si el precio no es válido -->
        <strong class="error">Precio no válido. Debe ser un número con hasta dos decimales.</strong>
    <?php endif; ?>

    <!-- Campo para el stock del producto -->
    <label for="stock">Stock</label>
    <input type="text" name="stock" value="<?= isset($_SESSION['form_data']['stock']) ? $_SESSION['form_data']['stock'] : $producto->getStock() ?>">
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_stock'): ?>
        <!-- Mensaje de error si el stock no es válido -->
        <strong class="error">Stock no válido. Debe ser un número.</strong>
    <?php endif; ?>

    <!-- Campo para la oferta del producto -->
    <label for="oferta">Oferta</label>
    <input type="text" name="oferta" value="<?= isset($_SESSION['form_data']['oferta']) ? $_SESSION['form_data']['oferta'] : $producto->getOferta() ?>">
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_oferta'): ?>
        <!-- Mensaje de error si la oferta no es válida -->
        <strong class="error">Oferta no válida. Solo se permiten letras y números.</strong>
    <?php endif; ?>

    <!-- Campo para la imagen del producto -->
    <label for="imagen">Imagen</label>
    <input type="file" name="imagen">
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_imagen'): ?>
        <!-- Mensaje de error si la imagen no es válida -->
        <strong class="error">Imagen no válida. Solo se permiten archivos de imagen.</strong>
    <?php endif; ?>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios" class="boton boton-enviar">
</form>

<!-- Elimina las sesiones de edicion y form_data -->
<?php Utils::deleteSession('edicion'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Volver a la pagina de la lista de productos donde se encuentra el producto que se está editando -->
<a href="<?=BASE_URL?>producto/listaProductos&pagina=<?=$paginaProducto?>#<?=$producto->getId()?>" class="boton boton-volver">Volver a la lista de productos</a>