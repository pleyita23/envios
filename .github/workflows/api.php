<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include 'db.php';

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

switch ($method) {
    case 'GET':
        if ($action === 'listar') {
            $result = $conn->query("SELECT * FROM envios");
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data);
        }
        break;

    case 'POST':
        if ($action === 'crear') {
            $input = json_decode(file_get_contents("php://input"), true);
            $dest = $input['destinatario'];
            $dir = $input['direccion'];
            $desc = $input['descripcion'];
            $conn->query("INSERT INTO envios (destinatario, direccion, descripcion)
                          VALUES ('$dest', '$dir', '$desc')");
            echo json_encode(["status" => "ok", "message" => "Envío creado"]);
        }
        break;

    case 'PUT':
        if ($action === 'modificar') {
            $input = json_decode(file_get_contents("php://input"), true);
            $id = $input['id'];
            $dest = $input['destinatario'];
            $dir = $input['direccion'];
            $desc = $input['descripcion'];
            $conn->query("UPDATE envios SET destinatario='$dest', direccion='$dir',
                          descripcion='$desc' WHERE id=$id");
            echo json_encode(["status" => "ok", "message" => "Envío actualizado"]);
        }
        break;

    case 'DELETE':
        if ($action === 'eliminar') {
            $id = $_GET['id'];
            $conn->query("DELETE FROM envios WHERE id=$id");
            echo json_encode(["status" => "ok", "message" => "Envío eliminado"]);
        }
        break;

    default:
        echo json_encode(["error" => "Método no soportado"]);
        break;
}
?>
