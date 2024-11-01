<?php

namespace Model;

class Plantilla extends ActiveRecord {
    protected static $tabla = 'plantillas';
    protected static $columnasDB = ['id', 'nombre', 'plantilla'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->plantilla = $args['plantilla'] ?? '';
    }
}