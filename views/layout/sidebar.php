<div id="contenido">
    <!-- Barra lateral -->
    <aside id="sidebar">   
        <div class="block_aside">
            <?php
                $controlador_actual = $_GET['controller'] ?? null;
                $accion_actual = $_GET['action'] ?? null;
            ?> 
            <?php if(!isset($_SESSION['identity'])): ?>
                <a href="<?=BASE_URL?>usuario/register">Registro de nuevo cliente</a>
                <a href="<?=BASE_URL?>usuario/loginCookies">Iniciar sesi&oacute;n</a>
            <?php else: ?>
                <?php
                    $rol_actual = $_SESSION['identity']['rol'] ?? null;
                ?>

                <?php if($rol_actual === 'admin'): ?>
                    <a href="#">Gestionar categor&iacute;as</a>
                    <a href="#">Gestionar productos</a>
                    <a href="#">Gestionar pedidos</a>
                    <a href="#">Gestionar usuarios</a>
                    <div class="separator"></div>
                <?php endif; ?>

                <a href="#"><?= $_SESSION['identity']['nombre'] ?> <?= $_SESSION['identity']['apellidos'] ?></a>

                <a href="<?=BASE_URL?>usuario/logout">Cerrar sesi&oacute;n</a>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Contenido principal (aquí ira el main) -->