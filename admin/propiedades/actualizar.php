<?php

use App\Propiedad;
use  Intervention\Image\ImageManager as Image;
// Se verifica si el usuario esta autenticado o no sino se redirecciona al index
require '../../includes/app.php';

usuarioAutenticado();

// Validar la URL por ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

// Obtener los datos de la propiedad
$propiedad = Propiedad::find($id);
// Consultar para obtener vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores

$errores = Propiedad::getErrores();

// Ejecuta el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Asignar los atributos

    $args = $_POST['propiedad'];

    $propiedad->sincronizar($args);

    //Asignar files hacia una variable
    $errores = $propiedad->validar();
    // Generar un nombre unico

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Setear la imagen
    // Validación subida de archivos
    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::gd()->read($_FILES['propiedad']['tmp_name']['imagen']);
        $image->resize(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    // Insertar en la base de datos
    if (empty($errores)) { // Si el arreglo de errores esta vacio entonces se inserta en la base de datos
        //Almacenar la imagen

        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGENES . $nombreImagen);
        }        

        $propiedad->guardar();
    }
}

// Importar las funciones

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>
    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <div class="alert error">
        <?php echo $error ?>
    </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>