<?php

require 'app.php'; // Path: includes/funciones.php

function incluirTemplate(string $nombre, bool $incio = false)
{ // Path: includes/funciones.php
    include TEMPLATES_URL . "/" . $nombre . ".php"; // Path: includes/funciones.php/ Path: includes/funciones.php
}
