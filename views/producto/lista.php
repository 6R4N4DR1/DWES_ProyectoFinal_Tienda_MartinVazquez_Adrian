<h1>Lista de productos</h1>

<a href="<?=BASE_URL?>producto/crearProducto" class="boton">Crear un nuevo producto</a>

<?php if(count($productos) > 0): ?>
    <table>
        <thead>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>ID</th>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Stock</th>
                <th>Oferta</th>
                <th>Fecha</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>    
            <?php 
            // Itera sobre cada producto y muestra sus datos en una fila de la tabla
            foreach($productos as $producto): ?>
                <tr id="<?=$producto->getId();?>">
                    <td><?=$producto->getId();?></td>
                    <td><?=$categoriasMap[$producto->getCategoriaId()];?></td>
                    <td><?=$producto->getNombre();?></td>
                    <td><?=$producto->getPrecio();?></td>
                    <td><?=$producto->getStock();?></td>
                    <td><?=$producto->getOferta();?></td>
                    <td><?=$producto->getFecha();?></td>
                    <td>
                        <?php if($producto->getImagen()): ?>
                            <img src="<?=BASE_URL?>assets/images/<?=$producto->getImagen();?>" alt="<?=$producto->getNombre();?>" width="50">
                        <?php else: ?>
                            <span><?=$producto->getNombre();?></span>
                        <?php endif; ?>
                    </td>
                    <td class="editar-celda"><a href="<?=BASE_URL?>producto/edit&id=<?=$producto->getId()?>">Editar</a></td>
                    <td class="editar-celda"><a href="<?=BASE_URL?>producto/delete&id=<?=$producto->getId()?>">Eliminar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Mensaje de error si no hay productos registrados -->
    <strong class="error">No hay productos registrados</strong>
<?php endif; ?>

<div class="paginacion">
    <?php 
    // Verifica si hay más de una página de productos
    if($totalPaginas > 1): ?>
        <?php 
        // Muestra el botón "Anterior" si no estamos en la primera página
        if($_SESSION['pagina'] > 1): ?>
            <a href="<?=BASE_URL?>producto/listaProductos&pagina=<?=($_SESSION['pagina'] - 1)?>">
                <input type="button" class="boton" value="Anterior">
            </a>
        <?php endif; ?>
        <!-- Enlace para volver al inicio -->
        <a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>
        <?php 
        // Muestra el botón "Siguiente" si no estamos en la última página
        if($_SESSION['pagina'] < $totalPaginas): ?>
            <a href="<?=BASE_URL?>producto/listaProductos&pagina=<?=($_SESSION['pagina'] + 1)?>">
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