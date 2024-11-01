<?php

namespace Model;

class Curso extends ActiveRecord {
    protected static $tabla = 'cursos';
    protected static $columnasDB = ['id', 'name_curso', 'fecha_inicio', 'fecha_fin','duracion','colaborador', 'status'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name_curso = $args['name_curso'] ?? '';
        $this->fecha_inicio = $args['fecha_inicio'] ?? '';
        $this->fecha_fin = $args['fecha_fin'] ?? '';
        $this->duracion = $args['duracion'] ?? '';
        $this->colaborador = $args['colaborador'] ?? '';
        $this->status = $args['status'] ?? 1;
    }

    public function validar() {
        if(!$this->name_curso) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
    
        if(!$this->fecha_inicio) {
            self::$alertas['error'][] = 'La Fecha de Inicio es Obligatiorio';
        }
        if(!$this->fecha_fin) {
            self::$alertas['error'][] = 'El Fecha Final es Obligatorio';
        }
        if(!$this->duracion) {
            self::$alertas['error'][] = 'La Duración es Obligatorio';
        }

        if(!$this->colaborador) {
            self::$alertas['error'][] = 'El Colaborador es Obligatorio';
        }
        return self::$alertas;
    }

      // Revisa si el alumno ya existe
  public function existeCurso() {
    $query = " SELECT * FROM " . self::$tabla . " WHERE name_curso = '" . $this->name_curso . "' LIMIT 1";
    $resultado = self::$db->query($query);

    if($resultado->num_rows) {
        self::$alertas['error'][] = 'El Curso ya esta registrado';
    }

    return $resultado;
}
}