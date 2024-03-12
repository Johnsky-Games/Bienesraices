<?php
// Se verifica si el usuario esta autenticado o no sino se redirecciona al index
require '../../includes/app.php';

use App\Propiedad;
use App\Vendedor;
use  Intervention\Image\ImageManager as Image;

usuarioAutenticado();

// Base de datos

$propiedad = new Propiedad;

// Consultar para obtener todos vendedores

$vendedores = Vendedor::all();

// Arreglo con mensajes de errores

$errores = Propiedad::getErrores();

// Ejecuta el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** Crea una nueva Instancia */
    $propiedad = new Propiedad($_POST['propiedad']);

    /** SUBIDA DE ARCHIVOS */

    // Generar un nombre unico

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    //Setear la imagen

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::gd()->read($_FILES['propiedad']['tmp_name']['imagen']);
        $image->resize(800, 600);
        $propiedad->setImagen($nombreImagen);
    }

    // Validar

    $errores = $propiedad->validar();

    // Insertar en la base de datos
    if (empty($errores)) { // Si el arreglo de errores esta vacio entonces se inserta en la base de datos

        // Crear una carpeta para subir imagenes
        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        // Guardar la imagen en el servidor
        $image->save(CARPETA_IMAGENES . $nombreImagen);

        // Guardar en la base de datos
        $propiedad->guardar();
    }
}

// Importar las funciones

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Crear</h1>
    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alert error">
            <?php echo $error ?>
        </div>
    <?php endforeach; ?>
    <form action="/admin/propiedades/crear.php" method="POST" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_propiedades.php' ?>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>