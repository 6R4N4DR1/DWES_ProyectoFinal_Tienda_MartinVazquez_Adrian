<?php
    use helpers\Utils;
    use models\Usuario;
        
    $usuario = Usuario::getUserPorId($_SESSION['identity']['id']);
?>

<h1>Tu Cuenta</h1>

<?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'complete'): ?>
    <strong class="completado">Cuenta modificada. ¡Disfruta!</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'undefined'): ?>
    <strong class="advertencia">No has modificado nada. ning&uacute;n dato ha sido cambiado.</strong>
<?php elseif(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed'): ?>
    <strong class="fallido">Fallo encontrado, no se puedo editar los datos de tu cuenta. Prueba de nuevo</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>usuario/editarUsuario" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $_SESSION['identity']['nombre'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_nombre'): ?>
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $_SESSION['identity']['apellidos'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_apellidos'): ?>
        <strong class="error">Los apellidos no son v&aacute;lidos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $_SESSION['identity']['email'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_email'): ?>
        <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para la contraseña -->
    <label for="password">Contrase&ntilde;a</label>
    <input type="password" name="password" value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">
    
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_password'): ?>
        <strong class="error">La contrase&ntilde;a no es v&aacute;lida. M&iacute;nimo 8 caracteres, letras, n&uacute;meros y opcionalmente s&iacute;mbolos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios">
</form>

<?php Utils::deleteSession('edicion'); ?>
<?php Utils::deleteSession('form_data'); ?>

<a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>