<?php
header("Content-Type: application/json");

require "../config/database.php";

$conn = new MysqlConn();

$input = json_decode(file_get_contents('php://input'), true);

switch($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $conn->addElement(
            "INSERT INTO products (name, description, price) VALUES (:name, :description, :price)", 
            [
                "name" => $input["name"],
                "description" => $input["description"],
                "price" => $input["price"],
            ],
            "Product added succesfully"
        );
        break;
    case 'GET':
        $conn->getElement(
            "SELECT * FROM products"
        );
}
