<?php

    // se obtiene el id de la propiedad a mostrar en la url y se filtra para que sea un entero y no se pueda inyectar codigo malicioso en la base de datos

    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if (!$id) { // Si el id no es un entero
        header('Location: /');
    }

    //Importar la conexión
    $db = conectarDB();

    //Consultar los datos
    
    $query = "SELECT * FROM propiedades WHERE id = " . $id;

    //Obtener los resultados

    $resultado = mysqli_query($db, $query); // Ejecuta la consulta y guarda el resultado en la variable resultado
    $propiedad = mysqli_fetch_assoc($resultado); // Obtiene la propiedad y la guarda en la variable propiedad 

    if(!$resultado -> num_rows){ // Si no hay resultados en la consulta se redirige a la pagina principal 
        header('Location: /');
     }

?>



<h1><?php echo $propiedad['titulo'] ?></h1>
    <picture>
        <img src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="Imagen de la Propiedad">

    <div class="resumen-propiedad">
        <p class="precio">$ <?php echo $propiedad['precio']; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg"
                    alt="icono estacionamiento">
                <p><?php echo $propiedad['estacionamiento']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $propiedad['habitaciones']; ?></p>
            </li>
        </ul>
        <p><?php echo $propiedad['descripcion']; ?> </p>
    </div>

<?php
    //Cerrar la conexión
    mysqli_close($db);
?>