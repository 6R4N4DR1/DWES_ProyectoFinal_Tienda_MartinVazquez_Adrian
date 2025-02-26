<?php  
    use helpers\Utils;
?>

<h1>Registrar Usuario</h1>

<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <!-- Mensaje de éxito si el registro se completó -->
    <strong class="completado">Registro completado. ¡Bienvenido!</strong>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
    <!-- Mensaje de error si el registro falló -->
    <strong class="fallido">Registro fallido. Prueba otra vez.</strong>
<?php endif; ?>

<!-- Formulario de registro de usuario -->
<form action="<?=BASE_URL?>usuario/save" method="POST">
    <!-- Campo para el nombre -->
    <label for="nombre">Nombre</label>
    <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_nombre'): ?>
        <!-- Mensaje de error si el nombre no es válido -->
        <strong class="error">El nombre no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('register'); ?>
    <?php endif; ?>

    <!-- Campo para los apellidos -->
    <label for="apellidos">Apellidos</label>
    <input type="text" name="apellidos" required value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : '' ?>">

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_apellidos'): ?>
        <!-- Mensaje de error si los apellidos no son válidos -->
        <strong class="error">Los apellidos no son v&aacute;lidos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('register'); ?>
    <?php endif; ?>
    
    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_email'): ?>
        <!-- Mensaje de error si el correo no es válido -->
        <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('register'); ?>
    <?php endif; ?>
    
    <!-- Campo para la contraseña -->
    <label for="password">Contrase&ntilde;a</label>
    <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_password'): ?>
        <!-- Mensaje de error si la contraseña no es válida -->
        <strong class="error">La contrase&ntilde;a no es v&aacute;lida. M&iacute;nimo 8 caracteres, letras, n&uacute;meros y opcionalmente s&iacute;mbolos. Prueba de nuevo.</strong>
        <?php Utils::deleteSession('register'); ?>
    <?php endif; ?>
    
    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Registrarse">
</form>

<!-- Elimina las sesiones de register y form_data -->
<?php Utils::deleteSession('register'); ?>
<?php Utils::deleteSession('form_data'); ?>