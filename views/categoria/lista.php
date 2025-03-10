<h1>Lista de categori&aacute;s</h1>

<!-- Enlace para crear una nueva categoría -->
<a href="<?=BASE_URL?>categoria/crearCategoria" class="boton">Crear una nueva categor&iacute;a</a>

<?php if(count($categorias) > 0): ?>
    <!-- Tabla para mostrar las categorías -->
    <table>
        <thead>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>ID</th>
                <th>Nombre</th>
            </tr>
        </thead>
        <tbody>    
            <?php 
            // Itera sobre cada categoría y muestra sus datos en una fila de la tabla
            foreach($categorias as $categoria): ?>
                <tr id="<?=$categoria->getId();?>">
                    <td><?=$categoria->getId();?></td>
                    <td><?=$categoria->getNombre();?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Mensaje de error si no hay categorías registradas -->
    <strong class="error">No hay categor&iacute;as registradas</strong>
<?php endif; ?>

<div class="paginacion">
    <?php 
    // Verifica si hay más de una página de categorías
    if($totalPaginas > 1): ?>
        <?php 
        // Muestra el botón "Anterior" si no estamos en la primera página
        if($_SESSION['pagina'] > 1): ?>
            <a href="<?=BASE_URL?>categoria/listaCategorias&pagina=<?=($_SESSION['pagina'] - 1)?>">
                <input type="button" class="boton" value="Anterior">
            </a>
        <?php endif; ?>
        <!-- Enlace para volver al inicio -->
        <a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>
        <?php 
        // Muestra el botón "Siguiente" si no estamos en la última página
        if($_SESSION['pagina'] < $totalPaginas): ?>
            <a href="<?=BASE_URL?>categoria/listaCategorias&pagina=<?=($_SESSION['pagina'] + 1)?>">
                <input type="button" class="boton" value="Siguiente">
            </a>
        <?php endif; ?>
    <?php else: ?>
        <!-- Enlace para volver al inicio -->
        <a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>
    <?php endif; ?>
</div>

<?php
/**
 * Nota:
 * La paginación se ha realizado con sesiones debido a que Composer da error y no funciona como lo esperado.
 */
?>