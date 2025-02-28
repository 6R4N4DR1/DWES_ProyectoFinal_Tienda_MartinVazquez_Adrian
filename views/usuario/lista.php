<h1>Lista de usuarios</h1>

<?php if(isset($usuarios) && count($usuarios) > 0): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th></th>
            </tr>
        </thead>
        <tbody>    
            <?php foreach($usuarios as $usuario): ?>
                <tr id="user#<?=$usuario->getId();?>">
                    <td><?=$usuario->getId();?></td>
                    <td><?=$usuario->getNombre();?></td>
                    <td><?=$usuario->getApellidos();?></td>
                    <td><?=$usuario->getEmail();?></td>
                    <td><?=($usuario->getRol() === 'admin') ? 'Administrador' : 'Usuario'?></td>
                    <td><a href="<?=BASE_URL?>usuario/editarUsuario&id=<?=$usuario->getId()?>" class="button button-modificar">Editar</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <strong>No hay usuarios registrados</strong>
<?php endif; ?>

<div class="paginacion">
    <?php if($totalPaginas > 1): ?>
        <?php if($_SESSION['pagina'] > 1): ?>
            <a href="<?=BASE_URL?>usuario/listaUsuarios&pagina=<?=($_SESSION['pagina'] - 1)?>">
                <input type="button" class="boton" value="Anterior">
            </a>
        <?php endif; ?>
        <?php if($_SESSION['pagina'] < $totalPaginas): ?>
            <a href="<?=BASE_URL?>usuario/listaUsuarios&pagina=<?=($_SESSION['pagina'] + 1)?>">
                <input type="button" class="boton" value="Siguiente">
            </a>
        <?php endif; ?>
    <?php endif; ?>
</div>