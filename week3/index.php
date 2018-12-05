<?php
/**
 * Controller
 * User: reinardvandalen
 * Date: 05-11-18
 * Time: 15:25
 */


/* Require composer autoloader */
require __DIR__ . '/vendor/autoload.php';

/* Include model.php */
include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt18_week3', 'ddwt18', 'ddwt18');

/* Set credentials */
$cred = set_cred('ddwt18', 'ddwt18');

/* Create Router instance */
$router = new \Bramus\Router\Router();

/* Authentication check */
$router->before('GET|POST|PUT\DELETE', '/api/.*', function() use($cred) {
    if (!check_cred($cred)) {
        $feedback = [
            'type' => 'danger',
            'message' => 'Authentication failed. Please check the credentials.'
        ];
        echo json_encode($feedback);
        exit();
    }
});

/* Mount the Router and add the routes */
$router->mount('/api', function() use ($db, $router){
    header('Content-Type: application/json');
    $router->get('/api/series', function() use($db) {
        $feedback = get_series($db);
         echo json_encode($feedback);
    });
    $router->get('/api/series/(\d+)', function($id) use($db) {
        $feedback = get_serieinfo($db, $id);
        echo json_encode($feedback);
    });
    $router->delete('/api/series/(\d+)', function($id) use ($db) {
        $feedback = remove_serie($db, $id);
        echo json_encode($feedback);
    });
    $router->post('/api/series/', function($_POST) use ($db) {
        $feedback =  add_serie($db, $_POST);
        echo json_encode($feedback);
    });
    $router->put('/api/series/(\d+)', function($id) use ($db) {
        $_PUT = array();
        parse_str(file_get_contents('php://input'), $_PUT);
        $serie_info = $_PUT + ["serie_id" => $id];
        $feedback = update_series($db, $serie_info);
        echo json_encode($feedback);
    });
});

/* Set error in case not accessible route is entered */
$router->set404(function() {
    header('HTTP:/1.1 404 Not Found');
    echo json__encode('Error 404: Resource not found');
});

/* Run the router */
$router->run();
