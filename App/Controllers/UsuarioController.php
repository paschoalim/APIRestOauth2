<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\Mysql\UsuarioDAO;
use App\Modals\UsuarioModel;

final class UsuarioController
{
        public function getUsuarios(Request $request,Response $response, array $args): Response
        {
              $usuariosDAO = new UsuarioDAO();
              $usuarios = $usuariosDAO->getAllUsuarios();
              $response = $response->withJson($usuarios); 
              return $response; 
        }
        public function insertUsuario(Request $request,Response $response, array $args): Response
        {
              $data = $request->getParsedBody();
               
              $UsuarioDAO = new UsuarioDAO();
              $usuario = new UsuarioModel();
              $usuario->setNome($data['nome']);
              $usuario->setEmail($data['email']);
              $senhaCripto = password_hash($data['senha'], PASSWORD_DEFAULT);
              $usuario->setSenha($senhaCripto);
              
              $UsuarioDAO->insertUsuario($usuario); 

              return $response->withStatus(201);

        }
        public function updateUsuario(Request $request,Response $response, array $args): Response
        {
              $data = $request->getParsedBody();
               
              $UsuarioDAO = new UsuarioDAO();
              $usuario = new UsuarioModel();
              $usuario->setId($data['id']);
              $usuario->setNome($data['nome']);
              $usuario->setEmail($data['email']);
              $senhaCripto = password_hash($data['senha'], PASSWORD_DEFAULT);
              $usuario->setSenha($senhaCripto);
             

              $UsuarioDAO->updateUsuario($usuario); 
              
              return $response->withStatus(201);
             
        }
        public function deleteUsuario(Request $request,Response $response, array $args): Response
        {
              $UsuarioDAO = new UsuarioDAO();
              $id = $args['id'];
              $UsuarioDAO->deleteUsuario($id); 
              return $response->withStatus(200);
        }

}
