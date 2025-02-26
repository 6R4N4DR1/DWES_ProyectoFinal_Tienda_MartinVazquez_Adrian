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
                <a href="<?=BASE_URL?>index.php">
                    <h1>Tienda - La charcuter&iacute;a de Don Manolo</h1>
                </a>
            </div>
        </header>
        <!-- Menú de navegación -->
        <nav>
            <ul>
                <li>
                    <a href="<?=BASE_URL?>">
                        Categor&iacute;a 1
                    </a>
                </li>
                <li>
                    <a href="<?=BASE_URL?>">
                        Categor&iacute;a 2
                    </a>
                </li>
                <li>
                    <a href="<?=BASE_URL?>">
                        Categor&iacute;a 3
                    </a>
                </li>
            </ul>
        </nav>