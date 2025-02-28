<?php 
    use helpers\Utils; 
?>

<h1>Crear Nuevo Usuario</h1>

<?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
    <!-- Mensaje de éxito si el registro se completó -->
    <strong class="completado">Nuevo usuario creado. ¡Se cort&eacute;s y dale tu bienvenida!</strong>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
    <!-- Mensaje de error si el registro falló -->
    <strong class="fallido">Creaci&oacute;n fallida. Prueba otra vez.</strong>
<?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_email_duplicado'): ?>
    <!-- Mensaje de error si el email ya existe -->
    <strong class="fallido">El correo ya está registrado. Prueba con otro.</strong>
<?php endif; ?>

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

    <!-- Campo para el rol -->
    <label for="rol">Rol</label>
    <select name="rol">
        <option value="user" <?= isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'user' ? 'selected' : '' ?>>Usuario/a</option>
        <option value="admin" <?= isset($_SESSION['form_data']['rol']) && $_SESSION['form_data']['rol'] == 'admin' ? 'selected' : '' ?>>Administrador/a</option>
    </select>

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Crear Usuario">
</form>

<!-- Elimina las sesiones de register y form_data -->
<?php Utils::deleteSession('register'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Botón para volver al inicio -->
<a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>