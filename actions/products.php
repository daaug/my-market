<?php
header("Content-Type: application/json");

require "../config/database.php";

$conn = new MysqlConn();

$input = json_decode(file_get_contents('php://input'), true);

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $conn->insertElement(
            "products", 
            [
                "name" => $input["name"],
                "description" => $input["description"],
                "price" => $input["price"]
            ],
            "Product added succesfully"
        );
        break;
    case 'GET':
        $conn->getElementById(
            "products",
            //["id" => $input["id"]]
            ["id" => $_GET["id"]]
        );
    
    case 'DELETE':
        $conn->deleteElementById(
            "products",
            ["id" => $input["id"]],
            "Product deleted succesfully"
        );
    
}
