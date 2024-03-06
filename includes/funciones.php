<?php

require 'app.php'; // Path: includes/funciones.php

function incluirTemplate(string $nombre, bool $inicio = false)
{ // Path: includes/funciones.php
    include TEMPLATES_URL . "/" . $nombre . ".php"; // Path: includes/funciones.php/ Path: includes/funciones.php
}

function usuarioAutenticado(): bool
{ // Se crea una funcion para saber si el usuario esta autenticado o no
    session_start(); // Se inicia la sesion

    $auth = $_SESSION['login']; // Se crea una variable para saber si el usuario esta autenticado o no

    if ($auth) { // Si el usuario no esta autenticado
        return true; // Se retorna verdadero
    }
    return false; // Si el usuario esta autenticado se retorna falso
} // Path: includes/funciones.php