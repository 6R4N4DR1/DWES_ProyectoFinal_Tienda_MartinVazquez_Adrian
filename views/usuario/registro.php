<main>
    <?php  
        use helpers\Utils;
    ?>

    <h1>Registrar Usuario</h1>

    <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'complete'): ?>
        <strong class="completado">Registro completado. ¡Bienvenido!</strong>
    <?php elseif(isset($_SESSION['register']) && $_SESSION['register'] == 'failed'): ?>
        <strong class="fallido">Registro fallido. Prueba otra vez.</strong>
    <?php endif; ?>

    <form action="<?=BASE_URL?>usuario/save" method="POST">
        <label for="nombre">Nombre</label>
        <input type="text" name="nombre" required value="<?= isset($_SESSION['form_data']['nombre']) ? $_SESSION['form_data']['nombre'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_nombre'): ?>
            <strong class="error">El nombre no es v&aacute;lido. Solo letras y espacios. Prueba de nuevo.</strong>
            <?php Utils::deleteSession('register'); ?>
        <?php endif; ?>

        <label for="apellidos">Apellidos</label>
        <input type="text" name="apellidos" required value="<?= isset($_SESSION['form_data']['apellidos']) ? $_SESSION['form_data']['apellidos'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_apellidos'): ?>
            <strong class="error">Los apellidos no son v&aacute;lidos. Solo letras y espacios. Prueba de nuevo.</strong>
            <?php Utils::deleteSession('register'); ?>
        <?php endif; ?>
        
        <label for="email">Correo</label>
        <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_email'): ?>
            <strong class="error">El correo no es v&aacute;lido. Prueba de nuevo.</strong>
            <?php Utils::deleteSession('register'); ?>
        <?php endif; ?>
        
        <label for="password">Contrase&ntilde;a</label>
        <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

        <?php if(isset($_SESSION['register']) && $_SESSION['register'] == 'failed_password'): ?>
            <strong class="error">La contrase&ntilde;a no es v&aacute;lida. M&iacute;nimo 8 caracteres, letras, n&uacute;meros y opcionalmente s&iacute;mbolos. Prueba de nuevo.</strong>
            <?php Utils::deleteSession('register'); ?>
        <?php endif; ?>
        
        <input type="submit" value="Registrarse">
    </form>

    <?php Utils::deleteSession('register'); ?>
    <?php Utils::deleteSession('form_data'); ?>