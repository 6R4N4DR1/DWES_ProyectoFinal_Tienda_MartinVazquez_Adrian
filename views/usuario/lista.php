<!-- Título de la página -->
<h1>Lista de usuarios</h1>

<?php 
// Verifica si hay usuarios y si la cantidad es mayor a 0
if(isset($usuarios) && count($usuarios) > 0): ?>
    <table>
        <thead>
            <tr>
                <!-- Encabezados de la tabla -->
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th></th>
            </tr>
        </thead>
        <tbody>    
            <?php 
            // Itera sobre cada usuario y muestra sus datos en una fila de la tabla
            foreach($usuarios as $usuario): ?>
                <tr id="<?=$usuario->getId();?>">
                    <td><?=$usuario->getId();?></td>
                    <td><?=$usuario->getNombre();?></td>
                    <td><?=$usuario->getApellidos();?></td>
                    <td><?=$usuario->getEmail();?></td>
                    <td><?=($usuario->getRol() === 'admin') ? 'Administrador/a' : 'Usuario/a'?></td>
                    <!-- Enlace para editar el usuario -->
                    <td class="editar-celda"><a href="<?=BASE_URL?>usuario/edit&id=<?=$usuario->getId()?>">Editar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <!-- Mensaje de error si no hay usuarios registrados -->
    <strong class="error">No hay usuarios registrados</strong>
<?php endif; ?>

<div class="paginacion">
    <?php 
    // Verifica si hay más de una página de usuarios
    if($totalPaginas > 1): ?>
        <?php 
        // Muestra el botón "Anterior" si no estamos en la primera página
        if($_SESSION['pagina'] > 1): ?>
            <a href="<?=BASE_URL?>usuario/listaUsuarios&pagina=<?=($_SESSION['pagina'] - 1)?>">
                <input type="button" class="boton" value="Anterior">
            </a>
        <?php endif; ?>
        <!-- Enlace para volver al inicio -->
        <a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>
        <?php 
        // Muestra el botón "Siguiente" si no estamos en la última página
        if($_SESSION['pagina'] < $totalPaginas): ?>
            <a href="<?=BASE_URL?>usuario/listaUsuarios&pagina=<?=($_SESSION['pagina'] + 1)?>">
                <input type="button" class="boton" value="Siguiente">
            </a>
        <?php endif; ?>
    <?php else: ?>
        <!-- Mensaje de error si no hay usuarios registrados -->
        <strong class="error">No hay usuarios registrados</strong>
    <?php endif; ?>
</div>