<?php
    use helpers\Utils;
    use models\Usuario;

    // Obtiene los datos del usuario a editar por su ID
    $usuario = Usuario::getUserPorId($_GET['id']);

    // Obtiene todos los usuarios
    $usuarios = Usuario::getAllUsers();

    // Encuentra la posición del usuario en la lista
    $posicionUsuario = array_search($usuario, $usuarios);

    // Calcula la página en la que se encuentra el usuario
    $paginaUsuario = ceil(($posicionUsuario + 1) / USERS_PER_PAGE);
?>

<!-- Título de la página con el nombre y apellidos del usuario -->
<h1>Modificando: <?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></h1>

<?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'complete'): ?>
    <!-- Mensaje de éxito si la edición se completó -->
    <strong class="completado">Cuenta modificada. ¡Disfruta!</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'undefined'): ?>
    <!-- Mensaje de advertencia si no se modificó nada -->
    <strong class="advertencia">No has modificado nada. ning&uacute;n dato ha sido cambiado.</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed'): ?>
    <!-- Mensaje de error si la edición falló -->
    <strong class="fallido">Fallo encontrado, no se puedo editar los datos de tu cuenta. Prueba de nuevo</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>usuario/editarUsuario&id=<?=$_GET['id']?>" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $usuario->getNombre() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_nombre'): ?>
        <!-- Mensaje de error si el nombre no es válido -->
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $usuario->getApellidos() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_apellidos'): ?>
        <!-- Mensaje de error si los apellidos no son válidos -->
        <strong class="error">Los apellidos no son v&aacute;lidos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $usuario->getEmail() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_email'): ?>
        <!-- Mensaje de error si el correo no es válido -->
        <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el rol -->
    <label for="rol">Rol</label>
    <select name="rol">
        <option value="user" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'user') ? 'selected' : ($usuario->getRol() == 'user' ? 'selected' : '') ?>>Usuario/a</option>
        <option value="admin" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'admin') ? 'selected' : ($usuario->getRol() == 'admin' ? 'selected' : '') ?>>Administrador/a</option>
    </select>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios" class="boton boton-enviar">
</form>

<!-- Elimina las sesiones de edicion y form_data -->
<?php Utils::deleteSession('edicion'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Volver a la pagina de la lista de usuarios donde se encuentra el usuario que se esta editando -->
<a href="<?=BASE_URL?>usuario/listaUsuarios&pagina=<?=$paginaUsuario?>#<?=$usuario->getId()?>" class="boton boton-volver">Volver a la lista de usuarios</a>