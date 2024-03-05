<?php
// Validar la URL por ID valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

// Base de datos

require '../../includes/config/db.php';
$db = conectarDB();

// COnsulta para obtener los datos de la propiedad

$consulta = "SELECT * FROM propiedades WHERE id = " . $id;

$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);

// Consultar para obtener vendedores

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

// Arreglo con mensajes de errores

$errores = [];


$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamiento = $propiedad['estacionamiento'];
$vendedorId = $propiedad['vendedores_id'];
$imagenPropiedad = $propiedad['imagen'];

// Ejecuta el codigo despues de que el usuario envia el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST); // Trae la información cuando enviamos una petición por el metodo POST
    // echo "</pre>";
    // echo "<pre>";
    // var_dump($_FILES); // Perminte ver la información de los archivos que se estan enviando
    // echo "</pre>";

    // Se asignan los valores a las variables y se limpian los datos de posibles inyecciones de codigo malicioso o caracteres especiales que puedan afectar la base de datos o el sistema en general
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamiento = mysqli_real_escape_string($db, $_POST['estacionamiento']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');

    //Asignar files hacia una variable

    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir un titulo";
    }

    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "Debes añadir una descripción de al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "Debes añadir el número de habitaciones";
    }

    if (!$wc) {
        $errores[] = "Debes añadir el número de baños";
    }

    if (!$estacionamiento) {
        $errores[] = "Debes añadir el número de estacionamientos";
    }

    if (!$vendedorId) {
        $errores[] = "Debes elejir un vendedor";
    }

    // Validar por tamaño (100kb maximo)

    $medida = 1000 * 100;

    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";

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

require '../../includes/funciones.php';
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
        <fieldset>
            <legend>Información General</legend>
            <label for="titulo">Titulo</label>
            <input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio</label>
            <input type="number" id="precio" name="precio" placeholder="Precio propiedad"
                value="<?php echo $precio; ?>">

            <label for=" imagen">Imagen</label>
            <input type="file" id="imagen" accept=" image/jpg, image/png" name="imagen">

            <img src="/imagenes/<?php echo $imagenPropiedad; ?>" alt="Imagen Propiedad" class="img-small">

            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" id="descripcion" cols="30" rows="10"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad</legend>

            <label for=" habitaciones">Habitaciones</label>
            <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej.: 3" min="1" max="9"
                value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños</label>
            <input type="number" id="wc" name="wc" placeholder="Ej.: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">Estacionamiento</label>
            <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej.: 3" min="1" max="9"
                value="<?php echo $estacionamiento; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>
            <select name="vendedor" id="">
                <option value="">-- Seleccione --</option>
                <?php
                while ($vendedor = mysqli_fetch_assoc($resultado)) : ?>
                <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?>
                    value="<?php echo $vendedor['id']; ?>">
                    <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>