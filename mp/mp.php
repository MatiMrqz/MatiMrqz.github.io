<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}


// SDK de Mercado Pago
require __DIR__ .  '/vendor/autoload.php';

$json = file_get_contents("php://input");
$data = json_decode($json);

if(!isset($data)){
    http_response_code(500);
    die("Bad Argument");
}

//Obtiene variables de entorno
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Agrega credenciales
MercadoPago\SDK::setAccessToken($_ENV['MP_TOKEN']);

// Crea un objeto de preferencia
$preference = new MercadoPago\Preference();

// Crea un ítem en la preferencia
$item = new MercadoPago\Item();
$item->title = 'Fitbox - '.$data->name;
$item->quantity = 1;
$item->unit_price = $data->price;
$preference->items = array($item);
$preference->back_urls=[
    "success"=>$_ENV['BASE_URL']."/payment_ok.html",
    "pending"=>$_ENV['BASE_URL']."/payment_ok.html",
    "failure"=>$_ENV['BASE_URL']."/payment_ok.html"
];
$preference->auto_return="approved";
$preference->statement_descriptor = "FITBOX";
$preference->save();

$response = array(
    'id' => $preference->id,
    'init_point' => $preference->init_point,
);
echo json_encode($response);
?>