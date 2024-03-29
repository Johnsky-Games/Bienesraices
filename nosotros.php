<?php
require 'includes/app.php';
incluirTemplate('header');
?>

<main class="contenedor seccion">
    <h1>Conoce Sobre Nosotros</h1>
    <div class="contenido-nosotros">
        <picture class="imagen">
            <source srcset="build/img/nosotros.webp" type="image.webp">
            <source srcset="build/img/nosotros.jpg" type="image.speg">
            <img src="/build/img/nosotros.jpg" alt="Imagen Sobre Nosotros">
        </picture>
        <div class="texto-nosotros">
            <blockquote>25 Años de Experiencia</blockquote>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi excepturi fugit esse dolore quaerat
                possimus hic sint nobis reiciendis vero, minus voluptate cupiditate facilis molestiae voluptas
                temporibus iste voluptatibus velit? Lorem ipsum dolor sit amet consectetur adipisicing elit. Labore
                ipsum at quo earum mollitia. Porro laudantium sunt ipsum omnis repellendus corrupti corporis animi,
                aliquam aperiam esse rerum iure reprehenderit fugit! Lorem ipsum dolor sit amet consectetur
                adipisicing elit. Ea, impedit. Saepe vitae cupiditate possimus quasi natus. Ducimus, laborum
                reiciendis quas cumque consequuntur libero recusandae facere laudantium nisi eum odit consequatur.
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, perferendis! Minus ab, obcaecati
                veritatis impedit fugit similique enim, ipsam quas nihil esse at totam modi fuga? Dignissimos nisi
                ex impedit?
            </p>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. At cum ut iste id culpa maiores ducimus eius
                modi, deserunt nesciunt, ipsum totam quae dolorum molestias, similique voluptatem quam. Eveniet,
                non. Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis perspiciatis fuga mollitia
                corporis repellat rem vitae dolores a sed, distinctio optio quasi consectetur labore amet alias
                eveniet debitis expedita quaerat?</p>
        </div>
    </div>
</main>
<section class="contenedor seccion">
    <h1>Más Sobre Nosotros</h1>
    <div class="iconos-nosotros">
        <div class="icono">
            <img src="/build/img/icono1.svg" alt="Icono Seguridad" loading="lazy">
            <h3>Seguridad</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos ratione quis molestias voluptas
                quae
                ducimus praesentium corporis, quibusdam asperiores illum. Distinctio, facere maiores.
                Repudiandae
                vel quae ut officiis temporibus fugiat!</p>
        </div>
        <div class="icono">
            <img src="/build/img/icono2.svg" alt="Icono Precio" loading="lazy">
            <h3>Precio</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos ratione quis molestias voluptas
                quae
                ducimus praesentium corporis, quibusdam asperiores illum. Distinctio, facere maiores.
                Repudiandae
                vel quae ut officiis temporibus fugiat!</p>
        </div>
        <div class="icono">
            <img src="/build/img/icono3.svg" alt="Icono Tiempo" loading="lazy">
            <h3>Tiempo</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos ratione quis molestias voluptas
                quae
                ducimus praesentium corporis, quibusdam asperiores illum. Distinctio, facere maiores.
                Repudiandae
                vel quae ut officiis temporibus fugiat!</p>
        </div>
    </div>
</section>

<?php
incluirTemplate('footer');
?>