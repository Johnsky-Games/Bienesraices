<?php
require 'includes/funciones.php';
incluirTemplate('header');
?>
<main class="contenedor seccion contenido-centrado">
    <h1>Casa en Venta Frente al Bosque</h1>
    <picture>
        <source srcset="build/img/destacada.webp" type="image/webp">
        <source srcset="build/img/destacada.jpg" type="image/jpeg">
        <img src="/build/img/destacada.jpg" alt="Imagen de la Propiedad">
    </picture>
    <div class="resumen-propiedad">
        <p class="precio">$3'000,000</p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_wc.svg" alt="icono wc">
                <p>3</p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_estacionamiento.svg"
                    alt="icono estacionamiento">
                <p>3</p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="/build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p>4</p>
            </li>
        </ul>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et lacus aliquet, auctor turpis suscipit,
            mattis lectus. Quisque vitae tortor non tortor commodo convallis a id lorem. Sed quis urna ut massa
            eleifend tristique ac eget nunc. Nam posuere scelerisque mattis. Donec sollicitudin ultrices dictum.
            Nunc ut felis maximus, condimentum risus vel, auctor neque. In hac habitasse platea dictumst.
            Suspendisse sollicitudin pretium molestie. Vestibulum quis rhoncus risus. Ut quis magna in mauris
            sodales rutrum non eget risus. Donec semper, dolor eget mattis rhoncus, leo lectus congue massa, vitae
            aliquet erat ex ac nisi. Donec sollicitudin elit lectus, condimentum pulvinar neque sodales at.
            Suspendisse sit amet velit eu turpis aliquet maximus quis et metus. Aliquam erat volutpat. Vestibulum
            ullamcorper purus nisi, eget tristique enim ultrices vel.</p>
        <p>Sed sed finibus magna. Ut interdum ullamcorper iaculis. Donec ornare iaculis risus ut egestas. Proin diam
            lorem, congue vitae aliquet id, volutpat sit amet elit. Praesent vehicula orci quis erat pharetra
            ultricies. In quis euismod justo. Morbi urna augue, posuere et tincidunt ac, ullamcorper vitae arcu.
            Nulla in orci congue justo volutpat eleifend a non risus. Curabitur gravida faucibus purus sed placerat.
            Suspendisse potenti. Aenean cursus nisi et risus dignissim lobortis. In a turpis sit amet odio vulputate
            imperdiet sed dapibus leo. Nulla facilisi. Nullam laoreet ligula facilisis mauris viverra egestas.
            Curabitur condimentum iaculis rutrum. Nunc convallis nibh dolor, eu pharetra nisl tincidunt a.</p>
    </div>
</main>

<?php
incluirTemplate('footer');
?>