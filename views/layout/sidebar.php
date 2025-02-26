<div id="contenido">
    <!-- Barra lateral -->
    <aside id="sidebar">
        <?php
            if(!isset($_SESSION['identity'])):
        ?>
        <h3>Iniciar Sesi&oacute;n ¡que diver!</h3>
        <div id="login" class="block_aside">
            <form action="<?=BASE_URL?>usuario/login" method="POST">
                <label for="email">Correo</label>
                <input type="email" name="email" required>
                <label for="password">Contrase&ntilde;a</label>
                <input type="password" name="password" required>
                <input type="submit" value="Enviar">
            </form>
        <?php else: ?>
            <h3><?=$_SESSION['identity']['nombre']?> <?=$_SESSION['identity']['apellidos']?> </h3>
        <?php endif; ?>    

            <a href="#">Mis pedidos</a>
            <a href="#">Gestionar pedidos</a>
            <a href="#">Gestionar categor&iacute;as</a>
        </div>
    </aside>

    <!-- Contenido principal (aquí ira el main) -->