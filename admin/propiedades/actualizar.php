<?php

use App\Propiedad;

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

    // Insertar en la base de datos
    if (empty($errores)) { // Si el arreglo de errores esta vacio entonces se inserta en la base de datos

        //**  Subida de archivos  */

        // Crear una carpeta

        $carpetaImagenes = '../../imagenes/';
        //Insertar en la base de datos
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        if ($imagen['name']) { // Si se sube una imagen entonces se ejecuta el siguiente codigo para subir la imagen a la carpeta de imagenes y se actualiza el nombre de la imagen en la base de datos de la propiedad que se esta actualizando
            // Eliminar la imagen previa
            unlink($carpetaImagenes . $propiedad['imagen']);

            // Generar un nombre unico

            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg"; // Se genera un nombre unico para la imagen

            //Subir la imagen 

            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen); // Se sube la imagen a la carpeta de imagenes    
        } else {
            $nombreImagen = $propiedad['imagen']; // Si no se sube una imagen se mantiene la imagen que ya estaba en la base de datos
        }


        $query = "UPDATE propiedades SET titulo = '" . $titulo . "', precio = '" . $precio . "', imagen = '" . $nombreImagen . "', descripcion = '" . $descripcion . "', habitaciones = " . $habitaciones . ", wc = " . $wc . ", estacionamiento = " . $estacionamiento . ", vendedores_id = " . $vendedorId . " WHERE id = " . $id;

        // echo $query;

        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            // Redireccionar al usuario
            header('Location: /admin?resultado=2');
        }
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