<?php

namespace Model;

class Diploma extends ActiveRecord {
    protected static $tabla = 'diplomas';
    protected static $columnasDB = ['id', 'alumno_id', 'curso_id','codigo','plantilla_id','token','status'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->alumno_id = $args['alumno_id'] ?? '';
        $this->curso_id = $args['curso_id'] ?? '';
        $this->codigo = $args['codigo'] ?? '';
        $this->plantilla_id = $args['plantilla_id'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->status = $args['status'] ?? 1;
    }

    public function validar() {
    
        if(!$this->curso_id  || !filter_var($this->curso_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Elige el Curso';
        }
        if(!$this->codigo) {
            self::$alertas['error'][] = 'Ingrese un codigo unico por alumno';
        }
        if(!$this->plantilla_id  || !filter_var($this->plantilla_id, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'Elige la plantilla';
        }

        return self::$alertas;
    }


  public function existeRegistro() {
    $query = " SELECT * FROM " . self::$tabla . " WHERE alumno_id = '" . $this->alumno_id . "' AND curso_id= '". $this->curso_id ."' LIMIT 1";

    $resultado = self::$db->query($query);

    if($resultado->num_rows) {
        self::$alertas['error'][] = 'Ya se registro el alumno en ese curso';
    }

    return $resultado;
}

public function existeCodigo() {
    $query = " SELECT * FROM " . self::$tabla . " WHERE codigo = '" . $this->codigo . "' LIMIT 1";
    $resultado = self::$db->query($query);

    if($resultado->num_rows) {
        self::$alertas['error'][] = 'Ese codigo ya esta registrado';
    }

    return $resultado;
}

public function existeAlumno() {
    $query = " SELECT * FROM " . self::$tabla . " WHERE alumno_id = '" . $this->alumno_id . "' LIMIT 1";

    $resultado = self::$db->query($query);

    if(!$resultado->num_rows) {
        self::$alertas['error'][] = 'El Alumno ya esta registrado';
    }

    return $resultado;
}

}