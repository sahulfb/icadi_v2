<?php

namespace Model;

class Alumno extends ActiveRecord {
    protected static $tabla = 'alumnos';
    protected static $columnasDB = ['id', 'pasaporte', 'fecha_nac', 'email','nombre', 'status','token'];

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->pasaporte = $args['pasaporte'] ?? '';
        $this->fecha_nac = $args['fecha_nac'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->nombre = $args['nombre'] ?? '';
        $this->status = $args['status'] ?? 1;
        $this->token = $args['token'] ?? '';
    }

         // Mensajes de validación para la creación de un evento
public function validar() {
    if(!$this->pasaporte) {
        self::$alertas['error'][] = 'El Pasaporte es Obligatorio';
    }

    if(!$this->fecha_nac) {
        self::$alertas['error'][] = 'La Fecha es Obligatiorio';
    }
    if(!$this->email) {
        self::$alertas['error'][] = 'El Correo es Obligatorio';
    }
    if(!$this->nombre) {
        self::$alertas['error'][] = 'El nombre es Obligatorio';
    }
    return self::$alertas;
}

  // Revisa si el alumno ya existe
  public function existeAlumno() {
    $query = " SELECT * FROM " . self::$tabla . " WHERE pasaporte = '" . $this->pasaporte . "' LIMIT 1";

    $resultado = self::$db->query($query);

    if($resultado->num_rows) {
        self::$alertas['error'][] = 'El Alumno ya esta registrado';
    }

    return $resultado;
}
}