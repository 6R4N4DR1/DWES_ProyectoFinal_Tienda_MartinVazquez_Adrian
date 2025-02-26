<?php
    namespace controllers;

    class ErrorController{
        public function index(): void{
            echo "<h1>Deja de buscar p&aacute;ginas que no existen, que est&aacute;s m&aacute;s perdio que una vaca buscando bellotas.</h1>";
            echo "<a href='".BASE_URL."'><button class=\"boton\">Vuelve al Inicio anda... Que est&aacute;s atontao perdio.</button></a>";
        }
    }
?>