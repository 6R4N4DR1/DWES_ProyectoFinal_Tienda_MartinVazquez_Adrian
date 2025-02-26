<?php
    use helpers\Utils; 
?>

<h1>Inicio de Sesi&oacute;n</h1>

<?php if(isset($_SESSION['login']) && $_SESSION['login'] == 'failed'): ?>
    <strong class="inicioFallido">Inicio de sesi&oacute;n fallido. Prueba de nuevo.</strong>
<?php endif; ?>

<form action="<?=BASE_URL?>usuario/login" method="POST">
    <label for="email">Correo</label>
    <input type="email" name="email" required value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>">
    
    <label for="password">Contrase&ntilde;a</label>
    <input type="password" name="password" required value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>">

    <div class="contenedorRecordar">
        <label for="recuerdame">Recordar este usuario</label>
        <input type="checkbox" id="recuerdame" name="recuerdame" <?= (isset($_SESSION['form_data']) && isset($_SESSION['form_data']['remember']) && $_SESSION['form_data']['remember']) ? 'checked' : '' ?>>
    </div>
    
    <input type="submit" value="Iniciar Sesi&oacute;n">
</form>

<?php Utils::deleteSession('login'); ?>
<?php Utils::deleteSession('form_data'); ?>