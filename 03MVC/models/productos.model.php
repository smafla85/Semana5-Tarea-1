<?php
// Clase para manejar operaciones de Productos
require_once('../config/config.php');

class Productos
{
    private $con;

    public function __construct()
    {
        $conectar = new ClaseConectar();
        $this->con = $conectar->ProcedimientoParaConectar();
    }

    // Método para ejecutar consultas SQL
    private function ejecutarConsulta($cadena)
    {
        $datos = mysqli_query($this->con, $cadena);
        if (!$datos) {
            throw new Exception(mysqli_error($this->con));
        }
        return $datos;
    }

    // Obtener todos los productos
    public function todos() 
    {
        $cadena = "SELECT * FROM `Productos`";
        return $this->ejecutarConsulta($cadena);
    }

    // Obtener un producto específico
    public function uno($idProductos) 
    {
        $idProductos = mysqli_real_escape_string($this->con, $idProductos);
        $cadena = "SELECT * FROM `Productos` WHERE `idProductos`='$idProductos'";
        return $this->ejecutarConsulta($cadena);
    }

    // Insertar un nuevo producto
    public function insertar($Codigo_Barras, $Nombre_Producto, $Graba_IVA)
    {
        try {
            // Escapar datos para prevenir inyección SQL
            $Codigo_Barras = mysqli_real_escape_string($this->con, $Codigo_Barras);
            $Nombre_Producto = mysqli_real_escape_string($this->con, $Nombre_Producto);
            $Graba_IVA = mysqli_real_escape_string($this->con, $Graba_IVA);
            
            $cadena = "INSERT INTO `Productos` (`Codigo_Barras`, `Nombre_Producto`, `Graba_IVA`) VALUES ('$Codigo_Barras','$Nombre_Producto','$Graba_IVA')";
            $this->ejecutarConsulta($cadena);
            return $this->con->insert_id;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Actualizar un producto existente
    public function actualizar($idProductos, $Codigo_Barras, $Nombre_Producto, $Graba_IVA)
    {
        try {
            // Escapar datos para prevenir inyección SQL
            $idProductos = mysqli_real_escape_string($this->con, $idProductos);
            $Codigo_Barras = mysqli_real_escape_string($this->con, $Codigo_Barras);
            $Nombre_Producto = mysqli_real_escape_string($this->con, $Nombre_Producto);
            $Graba_IVA = mysqli_real_escape_string($this->con, $Graba_IVA);
            
            $cadena = "UPDATE `Productos` SET `Codigo_Barras`='$Codigo_Barras', `Nombre_Producto`='$Nombre_Producto', `Graba_IVA`='$Graba_IVA' WHERE `idProductos` = '$idProductos'";
            $this->ejecutarConsulta($cadena);
            return $idProductos;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Eliminar un producto
    public function eliminar($idProductos)
    {
        try {
            $idProductos = mysqli_real_escape_string($this->con, $idProductos);
            $cadena = "DELETE FROM `Productos` WHERE `idProductos`= '$idProductos'";
            $this->ejecutarConsulta($cadena);
            return 1;
        } catch (Exception $th) {
            return "Error: " . $th->getMessage();
        }
    }

    // Cerrar la conexión al destruir el objeto
    public function __destruct()
    {
        if ($this->con) {
            $this->con->close();
        }
    }
}
?>