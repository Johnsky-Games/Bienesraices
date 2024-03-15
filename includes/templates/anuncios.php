<?php
  use App\Propiedad;

  $propiedades = Propiedad::all();

  //limitar a 3 propiedades aleatorias
    $inicio = rand(0, count($propiedades) - 3);
    $propiedades = array_slice($propiedades, $inicio, 3);
?>


<div class="contenedor-anuncios">

    <?php foreach($propiedades as $propiedad){ ?>

    <div class="anuncio">
             
                <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">
            
        <div class="contenido-anuncio">
            <h3><?php echo $propiedad->titulo; ?></h3>
            <p><?php echo $propiedad->descripcion; ?></p>
            <p class="precio">$ <?php echo $propiedad->precio; ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg"
                        alt="icono estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg"
                        alt="icono habitaciones">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>

            <a href="anuncio.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                Ver porpiedad
            </a>
        </div>
        <!--.contenido-anuncio -->
    </div>
    <!--.anuncio-->
    <?php } ?>
</div>
<!--.contenedor-anuncios-->