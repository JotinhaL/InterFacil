<?php

header('Content-Type: application/json');

// se tiverem problemas com CORS, a solução está comentada aqui embaixo
// CORS Headers:
// header("Access-Control-Allow-Origin: http://localhost");
// header('Access-Control-Allow-Credentials: true');
// header('Access-Control-Max-Age: 86400');    // cache for 1 day
// header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
// header("Access-Control-Allow-Headers: Content-Type, Origin, Cache-Control, Authorization, Accept");

require_once 'config/Routes.php';

// verifica se houve uma rota válida no acesso do php
if (!$_REQUEST['url']) {
    http_response_code(403);
    echo json_encode(array('status' => 'Bad Request', 'data' => 'Invalid Url'));
    exit;
}

$route = "/{$_REQUEST['url']}";

$route_exists = $routes[$route] ?? "";

if (empty($route_exists)) {
    http_response_code(404);
    echo json_encode(array('status' => 'Not Found', 'data' => 'Not Found URL'));
    exit;
}

try {
    $controllerName = explode('/', $routes[$route]);
    $controller = 'Controllers\\' . ucfirst($controllerName[0]) . 'Controller';
    // se não houver subrota, então considerar a primeira
    $method = $controllerName[1] ?? $controllerName[0];
    
    // adicionando visão arquivo, para não adicionar visão todos o controllers sempre que fizer uma requisição;
    require_once __DIR__ . "\\{$controller}.php";
    
    // funcao auxiliar do php para acionar um callback, que foi construido de forma a acessar o controller que desejamos;
    call_user_func_array(array(new $controller, $method), array());
} catch (\Exception $e) {
    // caso algo fuja do controle, devolver 500(Server Internal Error)
    http_response_code(500);
    echo json_encode(
            array(
                'status' => 'error',
                'msg' => $e->getMessage()
            ), 
            JSON_UNESCAPED_UNICODE
        );
}
exit;