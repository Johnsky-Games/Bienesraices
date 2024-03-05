<?php
//importar la conexion
require '../includes/config/db.php';
$db = conectarDB();
// Escribir el query
$query = 'SELECT * FROM propiedades';
//Consultar la base de datos

$resultadoConsulta = mysqli_query($db, $query);

// Muestra mensaje condicional
$resultado = $_GET['resultado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si se envia un formulario por el metodo POST se ejecuta el siguiente codigo
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    // Filtra el id para que sea un entero y no se pueda inyectar codigo malicioso en la base de datos
    if ($id) {

        //Eliminar el archivo

        $query = "SELECT imagen FROM propiedades WHERE id = " . $id; // Selecciona la imagen de la propiedad que se va a eliminar

        $resultado = mysqli_query($db, $query); // Ejecuta la consulta
        $propiedad = mysqli_fetch_assoc($resultado); // Obtiene la propiedad

        unlink('../imagenes/' . $propiedad['imagen']); // Elimina la imagen de la carpeta imagenes

        //Eliminar la propiedad
        $query = "DELETE FROM propiedades WHERE id = " . $id;
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?resultado=3');
        }
    }
}

// Incluye un template
require '../includes/funciones.php';
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

        <?php while ($propiedad = mysqli_fetch_assoc($resultadoConsulta)) : ?>
        <tr>
            <td><?php echo $propiedad['id']; ?></td>
            <td><?php echo $propiedad['titulo']; ?></td>
            <td><img src=" /imagenes/<?php echo $propiedad['imagen']; ?>" class="imagen-tabla" alt="imagen-tabla">
            </td>
            <td>$ <?php echo $propiedad['precio']; ?></td>
            <td>

                <form method="POST" class="w-100">
                    <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">
                </form>

                <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>"
                    class="boton-amarillo-block">Actualizar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
// Cerrar la conexion

mysqli_close($db);

incluirTemplate('footer');
?>