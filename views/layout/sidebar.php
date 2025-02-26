<div id="contenido">
    <!-- Barra lateral -->
    <aside id="sidebar">   
        <div class="block_aside">
            <?php
                // Obtiene el controlador y la acción actual de la URL
                $controlador_actual = $_GET['controller'] ?? null;
                $accion_actual = $_GET['action'] ?? null;
            ?> 
            <?php if(!isset($_SESSION['identity'])): ?>
                <!-- Enlaces para registrarse e iniciar sesión si el usuario no está identificado -->
                <a href="<?=BASE_URL?>usuario/register" class="boton">Registrarse</a>
                <a href="<?=BASE_URL?>usuario/loginCookies" class="boton">Iniciar sesi&oacute;n</a>
            <?php else: ?>
                <?php
                    // Obtiene el rol actual del usuario
                    $rol_actual = $_SESSION['identity']['rol'] ?? null;
                ?>

                <!-- Información de la cuenta del usuario -->
                <h3>Cuenta</h3>
                <a href="#" class="enlaceRojo"><?= $_SESSION['identity']['nombre'] ?> <?= $_SESSION['identity']['apellidos'] ?></a>
                <a href="<?=BASE_URL?>usuario/logout" class="enlaceRojo">Cerrar sesi&oacute;n</a>

                <!-- Separador horizontal -->
                <div class="separator"></div>

                <?php if($rol_actual === 'admin'): ?>
                    <!-- Enlaces de gestión para el administrador -->
                    <h3>Gestiones de administrador</h3>
                    <a href="#" class="boton">Gestionar usuarios</a>
                    <a href="#" class="boton">Gestionar pedidos</a>
                    <a href="#" class="boton">Gestionar productos</a>
                    <a href="<?=BASE_URL?>categoria/index" class="boton">Gestionar categor&iacute;as</a>
                    
                    <!-- Separador horizontal -->
                    <div class="separator"></div>
                <?php endif; ?>

                <!-- Enlaces a otras páginas -->
                <h3>P&aacute;ginas</h3>
                <a href="#" class="boton">Mis pedidos</a>
                <a href="#" class="boton">Productos</a>
                <a href="#" class="boton">Categor&iacute;as</a>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Contenido principal (aquí ira el main) -->