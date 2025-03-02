<?php 
    use helpers\Utils; 
?>

<h1>Crear Nueva Categor&iacute;a</h1>

<?php if(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'complete'): ?>
    <!-- Mensaje de éxito si la categoría se creó correctamente -->
    <strong class="completado">Nueva categor&iacute;a creada con &eacute;xito</strong>
<?php elseif(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'failed'): ?>
    <!-- Mensaje de error si la categoría no se creó correctamente -->
    <strong class="fallido">Creaci&oacute;n fallida. Prueba otra vez.</strong>
<?php elseif(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'failed_existe'): ?>
    <!-- Mensaje de error si la categoría ya existe -->
    <strong class="fallido">La categor&iacute;a ya existe. Prueba con otro nombre.</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>categoria/save" method="POST">
    <!-- Campo para el nombre de la categoría -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">

    <?php if(isset($_SESSION['categoria']) && $_SESSION['categoria'] == 'failed_nombre'): ?>
        <!-- Mensaje de error si el nombre no es válido -->
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('categoria'); ?>
    <?php endif; ?>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Crear categor&iacute;a">
</form>

<!-- Elimina las sesiones de register y form_data -->
<?php Utils::deleteSession('categoria'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Botón para volver a la última página de la lista de categorías -->
<a href="<?=BASE_URL?>categoria/listaCategorias&pagina=<?=$totalPaginas?>" class="boton boton-volver">Volver a la lista de categor&iacute;as</a>