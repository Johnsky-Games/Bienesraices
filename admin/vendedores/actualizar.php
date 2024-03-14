<?php
// Se verifica si el usuario esta autenticado o no sino se redirecciona al index
require '../../includes/app.php';

use App\Vendedor;

usuarioAutenticado();

//Validar que sea un id valido

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

//Obtener el arreglo de vendedor desde la base de datos

$vendedor = Vendedor::find($id);
// Arreglo con mensajes de errores

$errores = Vendedor::getErrores();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Asignar los valores
    $args = $_POST['vendedor'];
    //Sincronizar el objeto en memoria con lo que el usuario escribio
    $vendedor->sincronizar($args);

    //Validacion
    $errores = $vendedor->validar();
    if (empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>
    <a href="/admin/" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error) : ?>
    <div class="alert error">
        <?php echo $error; ?>
    </div>
    <?php endforeach; ?>
    <form method="POST" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario_vendedores.php'; ?>

        <input type="submit" value="Guardar Cambios" class="boton boton-verde">
    </form>
</main>

<?php
incluirTemplate('footer');
?>