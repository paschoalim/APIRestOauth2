<?php

use function src\slimConfiguration;
use App\Controllers\ProdutoController;
use App\Controllers\LojaController;
use App\Controllers\AuthController;
use App\Controllers\UsuarioController;
use App\Modals\UsuarioModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Tuupola\Middleware\JwtAuthentication;


$app = new \Slim\App(slimConfiguration());

$parametros = Array("secure" => false,
                    "secret" => getenv('JWT_SECRET_KEY'),
                    "algorithm" => ["HS256"]);



$app->post('/login', AuthController::class.':login');
$app->post('/logout', AuthController::class.':logout');
$app->post('/refresh', AuthController::class.':refresh');



$app->get('/usuarios', UsuarioController::class.':getUsuarios')
        ->add(new Tuupola\Middleware\JwtAuthentication($parametros));
$app->post('/usuario', UsuarioController::class.':insertUsuario')
        ->add(new Tuupola\Middleware\JwtAuthentication($parametros));
$app->put('/usuario', UsuarioController::class.':updateUsuario')
        ->add(new Tuupola\Middleware\JwtAuthentication($parametros));
$app->delete('/usuario/{id}', UsuarioController::class.':deleteUsuario')
        ->add(new Tuupola\Middleware\JwtAuthentication($parametros));





$app->run();
