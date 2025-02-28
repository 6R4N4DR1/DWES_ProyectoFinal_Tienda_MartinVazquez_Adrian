<?php
    use helpers\Utils;
    use models\Usuario;
        
    // Obtiene los datos del usuario actual
    $usuario = Usuario::getUserPorId($_SESSION['identity']['id']);
?>

<!-- Título de la página -->
<h1>Tu Cuenta</h1>

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

<form action="<?=BASE_URL?>usuario/editarUsuario" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : $_SESSION['identity']['nombre'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_nombre'): ?>
        <!-- Mensaje de error si el nombre no es válido -->
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : $_SESSION['identity']['apellidos'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_apellidos'): ?>
        <!-- Mensaje de error si los apellidos no son válidos -->
        <strong class="error">Los apellidos no son v&aacute;lidos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : $_SESSION['identity']['email'] ?>">

    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_email'): ?>
        <!-- Mensaje de error si el correo no es válido -->
        <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Campo para la contraseña -->
    <label for="password">Contrase&ntilde;a</label>
    <input type="password" name="password" value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">
    
    <?php if(isset($_SESSION['edicion']) && $_SESSION['edicion'] == 'failed_password'): ?>
        <!-- Mensaje de error si la contraseña no es válida -->
        <strong class="error">La contrase&ntilde;a no es v&aacute;lida. M&iacute;nimo 8 caracteres, letras, n&uacute;meros y opcionalmente s&iacute;mbolos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('edicion'); ?>
    <?php endif; ?>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Guardar cambios">
</form>

<!-- Elimina las sesiones de edicion y form_data -->
<?php Utils::deleteSession('edicion'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Botón para volver al inicio -->
<a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>