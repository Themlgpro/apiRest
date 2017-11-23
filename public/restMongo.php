<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
use \Slim\App;

$app = new \Slim\App;

$app->get('/listar', 'showData');
$app->post('/crear', 'addData');
$app->run();

function addData(Request $request, Response $response)
{
    //Taking the data
    $nombre = $request->getParam("nombre");
    $edad = $request->getParam("edad");
    $id = $request->getParam("id");
    $materias = $request->getParam("materias");
    $estado = $request->getParam("estado");
// connect
    $m = new MongoDB\Client;

// select your database
    $db = $m->estudiante;
    $collection = $db->estudiante;

    $insertOneResult = $collection->insertOne([
        'nombre'=>$nombre, 'edad' => $edad, 'materias' => $materias, 'id' => $id, 'estado' => $estado
        ]);

    echoResponse(200, $response);
}

function showData(Request $request, Response $response)
{
// connect
    $m = new MongoDB\Client("mongodb://localhost:27017");

// select your database
    $db = $m->estudiante;
    $collection = $db->estudiante;

    $getAll=$collection->find();
    $response = iterator_to_array($getAll);
    echoResponse(200, $response);
}



function echoResponse($status_code, $response) {
    $api = new \Slim\App;
    // Http response code
    $api->status($status_code);
     
    // setting response content type to json
    $api->contentType('application/json');
     
    echo json_encode($response);

}
?>