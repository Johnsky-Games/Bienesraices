<?php
// Se verifica si el usuario esta autenticado o no sino se redirecciona al index
require '../includes/app.php';
usuarioAutenticado();

use App\Propiedad;
use App\Vendedor;

//Implementar metodo para obtener todas las propiedades

$propiedades = Propiedad::all();
$vendedores = Vendedor::all();

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si se envia un formulario por el metodo POST se ejecuta el siguiente codigo
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    // Filtra el id para que sea un entero y no se pueda inyectar codigo malicioso en la base de datos
    if ($id) {

        $propiedad = Propiedad::find($id); // Obtiene la propiedad por su id
        $propiedad->eliminar();
    }
}

// Incluye un template

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php if (intval($resultado) == 1) : ?>
    <p class="alert exito">Anuncio creado correctamente.</p>
    <?php elseif (intval($resultado) == 2) : ?>
    <p class="alert exito">Anuncio Actualizado Correctamente.</p>
    <?php elseif (intval($resultado) == 3) : ?>
    <p class="alert exito">Anuncio Eliminado Correctamente.</p>
    <?php endif; ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

</main>

<table class="contenedor propiedades">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <!-- Mostrar los resultados -->
    <tbody>

        <?php foreach ($propiedades as $propiedad) : ?>
        <tr>
            <td><?php echo $propiedad->id; ?></td>
            <td><?php echo $propiedad->titulo; ?></td>
            <td><img src=" /imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla" alt="imagen-tabla">
            </td>
            <td>$ <?php echo $propiedad->precio; ?></td>
            <td>

                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>

                <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>"
                    class="boton-amarillo-block">Actualizar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
// Cerrar la conexion

mysqli_close($db);

incluirTemplate('footer');
?>