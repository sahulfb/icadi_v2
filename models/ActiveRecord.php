<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Setear un tipo de Alerta
    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Obtener las alertas
    public static function getAlertas() {
        return static::$alertas;
    }

    // Validación que se hereda en modelos
    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria (Active Record)
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Obtener todos los Registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allVigente() {
        $query = "SELECT * FROM " . static::$tabla . " WHERE status = 1";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = ${id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite} ORDER BY id DESC" ;
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($atributos));
        $query .= "') ";
        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {    
        // Eliminar el registro
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);    
        return $resultado;
    }
    

     // Busca un registro por su id
     public static function findPas($pas) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE pasaporte = ${pas}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function findName($name) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE nombre = ${name}";
        $resultado = self::consultarSQL($query);
        return $resultado ;
    }

    public static function whereDiploma($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = '${valor}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    //Paginar los registros
    public static function paginar($por_pagina, $offset) {
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id DESC LIMIT ${por_pagina} OFFSET ${offset}" ;
        $resultado = self::consultarSQL($query);
        return $resultado ;
    }

//traer total de registros
    public static function total($columna = '', $valor = '') {
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        if($columna){
            $query.= " WHERE ${columna} = ${valor}";
        }
        $resultado = self::$db->query($query);
        $total= $resultado->fetch_array();
        return array_shift($total);
    }

    public static function obtenerCertificado($codigo){
        $query = "SELECT a.nombre, a.pasaporte, d.codigo,d.token,d.plantilla_id ,c.name_curso,c.fecha_fin,c.duracion FROM ". static::$tabla ." a JOIN diplomas d ON a.id = d.alumno_id JOIN cursos c WHERE d.codigo=${codigo} AND d.curso_id=c.id";
        $resultados = self::$db->query($query);
        $newArray = array();
        while ($resultado = mysqli_fetch_assoc($resultados)) {
            $newArray[] = $resultado; 
        }
        return array_shift($newArray);
    }

    public static function obtenerCertificadoFecha($id){
        $query = "SELECT d.*, c.*, d.status 
        FROM " . static::$tabla . " d 
        JOIN cursos c ON d.curso_id = c.id 
        WHERE d.alumno_id=${id}";
        
     $resultados = self::$db->query($query);
     $newArray = array();
     while ($resultado = mysqli_fetch_assoc($resultados)) {
         $newArray[] = $resultado; 
     }
     return json_decode(json_encode($newArray));
    }

    public static function validarCodigo($pas, $codigo) {
        $query = "SELECT a.pasaporte, d.codigo, d.status FROM ". static::$tabla ." a 
                  JOIN diplomas d ON a.id = d.alumno_id 
                  WHERE d.codigo = ${codigo} AND a.pasaporte = ${pas} AND d.status = 1";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    

    public static function validarFecha($pas,$fecha){
        $query="SELECT * FROM " .static::$tabla. " WHERE TRIM(pasaporte) = TRIM('${pas}') AND fecha_nac= '${fecha}'";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function buscarId($codigo){
        $query = "SELECT * FROM " . static::$tabla . " WHERE codigo = '${codigo}' LIMIT 1";
        $resultado = self::$db->query($query);
        $total= $resultado->fetch_array();
        return $total;
    }

    public static function listaDiplomas($por_pagina, $offset){
        $query = "SELECT d.codigo,d.id,d.status,c.name_curso, p.nombre as nombrePlantilla, a.nombre as nombreAlumno
                  FROM ".static::$tabla." d
                  INNER JOIN alumnos a ON d.alumno_id = a.id
                  INNER JOIN cursos c ON d.curso_id = c.id
                  INNER JOIN plantillas p ON d.plantilla_id = p.id
                  ORDER BY d.id DESC
                  LIMIT ${por_pagina} OFFSET ${offset}";
    
        $resultados = self::$db->query($query);
        $newArray = array();
    
        while ($resultado = mysqli_fetch_assoc($resultados)) {
            $newArray[] = $resultado;
        }
    
        return json_decode(json_encode($newArray));
    }

    public static function buscarConJoin(array $columnas, $palabra) {
        // Escapar la palabra clave para evitar SQL Injection
        $palabra = self::$db->real_escape_string($palabra);
    
        // Crear la cláusula WHERE dinámica
        $whereClauses = [];
        foreach ($columnas as $columna) {
            $whereClauses[] = "{$columna} LIKE '%{$palabra}%'";
        }
        $where = implode(' OR ', $whereClauses);
    
        // Crear y ejecutar el query con JOIN
        $query = "SELECT d.codigo, d.id, d.status, c.name_curso, p.nombre as nombrePlantilla, a.nombre as nombreAlumno
                  FROM " . static::$tabla . " d
                  INNER JOIN alumnos a ON d.alumno_id = a.id
                  INNER JOIN cursos c ON d.curso_id = c.id
                  INNER JOIN plantillas p ON d.plantilla_id = p.id
                  WHERE {$where}
                  ORDER BY d.id DESC";
    
                  $resultados = self::$db->query($query);
                  $newArray = array();
              
                  while ($resultado = mysqli_fetch_assoc($resultados)) {
                      $newArray[] = $resultado;
                  }
              
                  return json_decode(json_encode($newArray));
    }
    
    
    

    public static function existeAlumnoPas($pass) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE pasaporte = " . $pass . " LIMIT 1";
        $resultado = self::$db->query($query);
        $total= $resultado->fetch_array();
        return $total;
    }

    public static function UpdateStatus($id,$status) {
        $query = "UPDATE " . static::$tabla . " SET status = '" . $status . "' WHERE id = '" . $id . "' LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function whereLike(array $columnas, $palabra) {
        // Escapar la palabra clave para evitar SQL Injection
        $palabra = self::$db->real_escape_string($palabra);
    
        // Crear la cláusula WHERE dinámica
        $whereClauses = [];
        foreach ($columnas as $columna) {
            $whereClauses[] = "{$columna} LIKE '%{$palabra}%'";
        }
        $where = implode(' OR ', $whereClauses);
    
        // Crear y ejecutar el query
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$where} ORDER BY id DESC";
        $resultado = self::consultarSQL($query);
    
        return $resultado;
    }
    
}