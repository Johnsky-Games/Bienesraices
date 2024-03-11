<?php

namespace App;

class Propiedad
{

    //BASE DE DATOS

    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    // Errores de validacion

    protected static $errores = [];

    //PROPIEDADES
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    //Definir la conexion a la base de datos

    public static function setDB($database)
    {
        self::$db = $database; // self es para acceder a las propiedades estaticas
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar()
    {
        //Satinitizar los datos
        $atributos = $this->satinizarAtributos();

        //Insertar en la base de datos
        $query = "INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function satinizarAtributos()
    {
        $atributos = $this->atributos();
        $satinizar = [];
        foreach ($atributos as $key => $value) {
            $satinizar[$key] = self::$db->escape_string($value);
        }
        return $satinizar;
    }

    //Subida de archivos

    public function setImagen($imagen)
    {
        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Validacion

    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }

        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }

        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "Debes añadir una descripción de al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "Debes añadir el número de habitaciones";
        }

        if (!$this->wc) {
            self::$errores[] = "Debes añadir el número de baños";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "Debes añadir el número de estacionamientos";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Debes elejir un vendedor";
        }

        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        return self::$errores;
    }

    // Lista todas las propiedades

    public static function all()
    {
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Consulta una propiedad por su ID

    public static function find($id)
    {
        // COnsulta para obtener los datos de la propiedad

        $query = "SELECT * FROM propiedades WHERE id = " . $id;
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        //Liberar la memoria
        $resultado->free();
        //Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Sincroniza el objeto en memoria con los cambios realizados por el usuario

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}