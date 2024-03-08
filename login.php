<?php
require 'includes/app.php';

// Importar la conexion
$db = conectarDB();

//Autenicar el usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // echo "<pre>";
    // var_dump($_SERVER['REQUEST_METHOD']);
    // echo "</pre>";

    $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (!$email) {
        $errores[] = "El email es obligatorio o no es válido";
    }

    if (!$password) {
        $errores[] = "El password es obligatorio";
    }

    if (empty($errores)) { // En este condigo si el array de errores esta vacio, se ejecuta el codigo
        //Revisar si el usuario existe
        $query = "SELECT * FROM usuarios WHERE email = '" . $email . "'";
        $resultado = mysqli_query($db, $query);

        if ($resultado->num_rows) {
            //Revisar si el password es correcto
            $usuario = mysqli_fetch_assoc($resultado); // Se obtiene el usuario de la base de datos y se guarda en un arreglo asociativo
            //Verificar si el password es correcto o no
            $auth = password_verify($password, ($usuario['password'])); // Se verifica si el password ingresado por el usuario es igual al password encriptado en la base de datos
            // var_dump($auth);
            if ($auth) {
                // El usuario esta autenticado
                session_start();

                //Llenar el arreglo de la sesion

                $_SESSION['usuario'] = $usuario['email']; // El email del usuario se guarda en la sesion con el nombre de usuario
                $_SESSION['login'] = true; // Se crea una variable de sesion para saber si el usuario esta logeado o no

                header('Location: /admin');
            } else {
                $errores[] = "La contraseña es incorrecta";
            }
        } else {
            $errores[] = "El Usuario no existe";
        }
    }
}
// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";
//Incluye el header

incluirTemplate('header');

?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>
    <?php

    foreach ($errores as $error) : ?>
        <div class="alert error">
            <?php echo $error; ?>
        </div>

    <?php endforeach; ?>

    <form method="POST" class="formulario" novalidate>

        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu e-mail" id="email">

            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Tu contraseña" id="password">

        </fieldset>

        <input type="submit" class="boton boton-verde" value="Iniciar Sesión">
    </form>

</main>

<?php

incluirTemplate('footer');

?>