<?php
    use helpers\Utils;
    use models\Usuario;

    $usuario = Usuario::getUserPorId($_GET['id']);
?>

<h1>Modificando: <?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></h1>

<?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'complete'): ?>
    <strong class="completado">Cuenta modificada. ¡Disfruta!</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'undefined'): ?>
    <strong class="advertencia">No has modificado nada. ning&uacute;n dato ha sido cambiado.</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed'): ?>
    <strong class="fallido">Fallo encontrado, no se puedo editar los datos de tu cuenta. Prueba de nuevo</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>usuario/editarUsuario&id=<?$_GET['id']?>" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $usuario->getNombre() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_nombre'): ?>
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $usuario->getApellidos() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_apellidos'): ?>
        <strong class="error">Los apellidos no son v&aacute;lidos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $usuario->getEmail() ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_email'): ?>
        <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el rol -->
    <label for="rol">Rol</label>
    <select name="rol">
        <option value="user" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'user') ? 'selected' : ($usuario->getRol() == 'user' ? 'selected' : '') ?>>Usuario</option>
        <option value="admin" <?= (isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'admin') ? 'selected' : ($usuario->getRol() == 'admin' ? 'selected' : '') ?>>Administrador</option>
    </select>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios">
</form>

<?php Utils::deleteSession('edicion'); ?>
<?php Utils::deleteSession('form_data'); ?>