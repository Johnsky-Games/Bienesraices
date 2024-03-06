<?php

session_start(); // Se inicia la sesion

$_SESSION = []; // Se vacia el contenido de la sesion

header('Location: /'); // Se redirige al usuario a la pagina principal

var_dump($_SESSION); // Se imprime el contenido de la sesion