<div id="contenido">
    <!-- Barra lateral -->
    <aside id="sidebar">   
        <div class="block_aside">
            <?php
                $controlador_actual = $_GET['controller'] ?? null;
                $accion_actual = $_GET['action'] ?? null;
            ?> 
            <?php if(!isset($_SESSION['identity'])): ?>
                <a href="<?=BASE_URL?>usuario/register" class="boton">Registrarse</a>
                <a href="<?=BASE_URL?>usuario/loginCookies" class="boton">Iniciar sesi&oacute;n</a>
            <?php else: ?>
                <?php
                    $rol_actual = $_SESSION['identity']['rol'] ?? null;
                ?>

                <h3>Cuenta</h3>
                <a href="#" class="enlaceRojo"><?= $_SESSION['identity']['nombre'] ?> <?= $_SESSION['identity']['apellidos'] ?></a>

                <a href="<?=BASE_URL?>usuario/logout" class="enlaceRojo">Cerrar sesi&oacute;n</a>

                <div class="separator"></div>
                <?php if($rol_actual === 'admin'): ?>
                    <h3>Gestiones de administrador</h3>
                    <a href="#" class="boton">Gestionar usuarios</a>
                    <a href="#" class="boton">Gestionar pedidos</a>
                    <a href="#" class="boton">Gestionar productos</a>
                    <a href="#" class="boton">Gestionar categor&iacute;as</a>
                    
                    <div class="separator"></div>
                <?php endif; ?>

                <h3>P&aacute;ginas</h3>
                <a href="#" class="boton">Mis pedidos</a>
                <a href="#" class="boton">Productos</a>
                <a href="#" class="boton">Categor&iacute;as</a>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Contenido principal (aquí ira el main) -->