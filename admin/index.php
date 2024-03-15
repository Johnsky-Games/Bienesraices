<?php
// Se verifica si el usuario esta autenticado o no sino se redirecciona al index
require '../includes/app.php';
usuarioAutenticado();
// Importar las clases
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
        $tipo = $_POST['tipo'];

        if (validarTipoContenido($tipo)) {
            // Comprobar si el tipo es vendedor o propiedad para eliminar el registro de la base de datos segun sea el caso 
            if ($tipo === 'vendedor') {
                $vendedor = Vendedor::find($id);
                $vendedor->eliminar();
            } else if ($tipo === 'propiedad') {
                $propiedad = Propiedad::find($id);
                $propiedad->eliminar();
            }
        }

        $propiedad = Propiedad::find($id); // Obtiene la propiedad por su id

        $propiedad->eliminar();
    }
}

// Incluye un template

incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raices</h1>
    <?php $mensaje = mostrarNotificacion(intval($resultado));
    if ($mensaje) { ?>
    <p class="alert exito"> <?php echo s($mensaje); ?></p>
    <?php } ?>
    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>
    <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo Vendedor</a>
    <h2>Propiedades</h2>
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
                        <input type="hidden" name="tipo" value="propiedad">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>

                    <a href="/admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>"
                        class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h2>Vendedores</h2>

    <table class="contenedor propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <!-- Mostrar los resultados -->
        <tbody>

            <?php foreach ($vendedores as $vendedor) : ?>
            <tr>
                <td><?php echo $vendedor->id; ?></td>
                <td><?php echo $vendedor->nombre . " " . $vendedor->apellido; ?></td>
                </td>
                <td><?php echo $vendedor->telefono; ?></td>
                <td>

                    <form method="POST" class="w-100">
                        <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>">
                        <input type="hidden" name="tipo" value="vendedor">
                        <input type="submit" class="boton-rojo-block" value="Eliminar">
                    </form>

                    <a href="/admin/vendedores/actualizar.php?id=<?php echo $vendedor->id; ?>"
                        class="boton-amarillo-block">Actualizar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>
<?php
incluirTemplate('footer');
?>