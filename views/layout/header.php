<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charcuter&iacute;a de Manolo</title>
    <!-- Enlace al archivo de estilos CSS con un parámetro de tiempo para evitar el caché -->
    <link rel="stylesheet" href="<?=BASE_URL?>assets/css/estilos.css?v=<?=time()?>" type="text/css">
    <!-- Enlace al icono de la página -->
    <link rel="icon" type="image/png" href="<?=BASE_URL?>assets/images/pepalacerda.png">
</head>
<body>
    <div id="contenedor">
        <!-- Cabecera de la página -->
        <header id="header">
            <div id="logo">
                <!-- Logo de la tienda -->
                <img src="<?=BASE_URL?>assets/images/donmanolo.png" alt="Don Manolo retrato">
                <!-- Enlace a la página principal -->
                <a href="<?=BASE_URL?>">
                    <h1>Tienda - La charcuter&iacute;a de Don Manolo</h1>
                </a>
            </div>
        </header>
        <!-- Menú de navegación -->
        <nav>
            <ul class="nav-categorias">
                <?php
                    use controllers\CategoriaController;
                    $paginaNav = isset($_GET['paginaNav']) ? (int)$_GET['paginaNav'] : 1;
                    list($categoriasNav, $totalPaginasNav) = CategoriaController::getCategoriasParaNav($paginaNav);
                ?>

                <?php if($paginaNav > 1): ?>
                    <li class="nav-flecha izquierda">
                        <a href="<?=BASE_URL?>?paginaNav=<?=($paginaNav - 1)?>" class="flecha">&laquo;</a>
                    </li>
                <?php endif; ?>
                
                <div class="nav-categorias-centro">
                    <?php foreach($categoriasNav as $categoria): ?>
                        <li class="nav-categoria">
                            <a href="<?=BASE_URL?>categoria/ver&id=<?=$categoria->getId()?>">
                                <?=$categoria->getNombre()?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </div>
                
                <?php if($paginaNav < $totalPaginasNav): ?>
                    <li class="nav-flecha derecha">
                        <a href="<?=BASE_URL?>?paginaNav=<?=($paginaNav + 1)?>" class="flecha">&raquo;</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>