<?php
    use helpers\Utils; 
?>

<!-- Título de la página -->
<h1>Inicio de Sesi&oacute;n</h1>

<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'failed'): ?>
    <!-- Mensaje de error si el inicio de sesión ha fallado -->
    <strong class="fallido">Inicio de sesi&oacute;n fallido. Prueba de nuevo.</strong>
<?php endif; ?>

<!-- Formulario de inicio de sesión -->
<form action="<?=BASE_URL?>usuario/login" method="POST">
    <!-- Campo para el correo electrónico -->
    <label for="email">Correo</label>
    <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">
    
    <!-- Campo para la contraseña -->
    <label for="password">Contrase&ntilde;a</label>
    <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

    <!-- Botón para enviar el formulario -->
    <input type="submit" value="Iniciar Sesi&oacute;n">
</form>

<!-- Elimina las sesiones de login y form_data -->
<?php Utils::deleteSession('login'); ?>
<?php Utils::deleteSession('form_data'); ?>

<!-- Botón para volver al inicio -->
<a href="<?=BASE_URL?>" class="boton boton-volver">Ir al inicio</a>