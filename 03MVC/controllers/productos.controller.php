<?php
// Configuración de cabeceras para CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    die();
}

require_once('../models/productos.model.php');
error_reporting(0);
$productos = new Productos;

// Función para enviar respuesta en formato JSON
function responseJson($data) {
    echo json_encode($data);
    exit;
}

switch ($_GET["op"]) {
    case 'todos': 
        // Obtener todos los productos
        $datos = $productos->todos();
        $todos = mysqli_fetch_all($datos, MYSQLI_ASSOC);
        responseJson($todos);
        break;

    case 'uno':
        // Obtener un producto específico
        $idProductos = $_POST["idProductos"];
        $datos = $productos->uno($idProductos);
        $res = mysqli_fetch_assoc($datos);
        responseJson($res);
        break;

    case 'insertar':
        // Insertar un nuevo producto
        $Codigo_Barras = $_POST["Codigo_Barras"];
        $Nombre_Producto = $_POST["Nombre_Producto"];
        $Graba_IVA = $_POST["Graba_IVA"];

        $datos = $productos->insertar($Codigo_Barras, $Nombre_Producto, $Graba_IVA);
        responseJson($datos);
        break;

    case 'actualizar':
        // Actualizar un producto existente
        $idProductos = $_POST["idProductos"];
        $Codigo_Barras = $_POST["Codigo_Barras"];
        $Nombre_Producto = $_POST["Nombre_Producto"];
        $Graba_IVA = $_POST["Graba_IVA"];

        $datos = $productos->actualizar($idProductos, $Codigo_Barras, $Nombre_Producto, $Graba_IVA);
        responseJson($datos);
        break;

    case 'eliminar':
        // Eliminar un producto
        $idProductos = $_POST["idProductos"];
        $datos = $productos->eliminar($idProductos);
        responseJson($datos);
        break;

    default:
        // Operación no válida
        responseJson(["error" => "Operación no válida"]);
}