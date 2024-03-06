<?php

//Importar la conexion
require 'includes/config/db.php';
$db = conectarDB();

// Crear un mail y password 
$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT); // Hashear el password con BCRYPT (Recomendado)

// Query para crear el usuario
$query = "INSERT INTO usuarios (email,password) VALUES('$email','$passwordHash')";

echo $query;

//Agregarlo a la base de datos

mysqli_query($db, $query);