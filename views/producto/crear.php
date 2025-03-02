<?php 
    use helpers\Utils; 
?>

<h1 class="titulo-formulario">Crear Nuevo Producto</h1>

<?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'complete'): ?>
    <!-- Mensaje de éxito si el producto se creó correctamente -->
    <strong class="completado">Nuevo producto creado con &eacute;xito</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed'): ?>
    <!-- Mensaje de error si el producto no se creó correctamente -->
    <strong class="fallido">Creaci&oacute;n fallida. Prueba otra vez.</strong>
<?php elseif(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_existe'): ?>
    <!-- Mensaje de error si el producto ya existe -->
    <strong class="error">El producto ya existe. Prueba otra vez.</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>producto/save" method="POST" enctype="multipart/form-data" class="formulario-producto">
    <!-- Campo para la categoría del producto -->
    <label for="categoria_id">Categoría</label>
    <select name="categoria_id" required>
        <?php foreach($categorias as $categoria): ?>
            <option value="<?= $categoria->getId(); ?>" <?= isset($_SESSION['form_data']['categoria_id']) && $_SESSION['form_data']['categoria_id'] == $categoria->getId() ? 'selected' : ''; ?>>
                <?= $categoria->getNombre(); ?>
            </option>
        <?php endforeach; ?>
    </select>
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_categoria_id'): ?>
        <strong class="error">Categoría no válida. Debe ser un número.</strong>
    <?php endif; ?>

    <!-- Campo para el nombre del producto -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_nombre'): ?>
        <strong class="error">Nombre no válido. Prueba de nuevo.</strong>
    <?php endif; ?>

    <!-- Campo para la descripción del producto -->
    <label for="descripcion">Descripción</label>
    <textarea name="descripcion"><?= isset($_SESSION['form_data']['descripcion']) ? $_SESSION['form_data']['descripcion'] : '' ?></textarea>

    <!-- Campo para el precio del producto -->
    <label for="precio">Precio</label>
    <input type="text" name="precio" required value="<?= isset($_SESSION['form_data']['precio']) ? $_SESSION['form_data']['precio'] : '' ?>">
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_precio'): ?>
        <strong class="error">Precio no válido. Debe ser un número con hasta dos decimales.</strong>
    <?php endif; ?>

    <!-- Campo para el stock del producto -->
    <label for="stock">Stock</label>
    <input type="text" name="stock" required value="<?= isset($_SESSION['form_data']['stock']) ? $_SESSION['form_data']['stock'] : '' ?>">
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_stock'): ?>
        <strong class="error">Stock no válido. Debe ser un número.</strong>
    <?php endif; ?>

    <!-- Campo para la oferta del producto -->
    <label for="oferta">Oferta</label>
    <input type="text" name="oferta" required value="<?= isset($_SESSION['form_data']['oferta']) ? $_SESSION['form_data']['oferta'] : '' ?>">
    <?php if(isset($_SESSION['producto']) && $_SESSION['producto'] == 'failed_oferta'): ?>
        <strong class="error">Oferta no válida. Solo se permiten letras y números.</strong>
    <?php endif; ?>

    <!-- Campo para la imagen del producto -->
    <label for="imagen">Imagen</label>
    <input type="file" name="imagen" required>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Crear producto" class="boton-enviar">
</form>

<!-- Elimina las sesiones de producto y form_data -->
<?php Utils::deleteSession('producto'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Botón para volver a la última página de la lista de productos -->
<a href="<?=BASE_URL?>producto/listaProductos&pagina=<?=$totalPaginas?>" class="boton boton-volver">Volver a la lista de productos</a>