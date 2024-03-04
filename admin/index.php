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
                <a href="/admin/propiedades/borrar.php" class="boton-rojo-block">Eliminar</a>
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