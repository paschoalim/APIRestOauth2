<?php
namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\Mysql\UsuarioDAO;
use App\DAO\Mysql\TokenDAO;
use App\Modals\UsuarioModel;
use App\Modals\TokenModel;
use Firebase\JWT\JWT;

final class AuthController
{
    public function login(Request $request,Response $response, array $args): Response
    {
           $data = $request->getParsedBody();
           
           $email = $data['email'];
           $senha = $data['senha'];
           $usuarioDAO = new UsuarioDAO();
           
           $usuario = $usuarioDAO->getUserByEmail($email);
            if (is_null($usuario)){
                return $response->withStatus(401);
            }

           if (!password_verify($senha, $usuario->getSenha())){
                return $response->withStatus(401);
           }
           
           $expiredAt = (new \DateTime()) -> modify('+2 days')
           ->format('Y-m-d H:i:s');

           $tokenPlayload = [
               'sub' => $usuario->getId(),
               'name' => $usuario->getNome(),
               'email' => $usuario->getEmail(),
               'expired_at' => $expiredAt
           ];

           $token = JWT::encode($tokenPlayload, getenv('JWT_SECRET_KEY'));
           $refreshTokenPayload = [
               'email'=>$usuario->getEmail()
           ];

           $refreshToken = JWT::encode($refreshTokenPayload, getenv('JWT_SECRET_KEY'));

           $tokenModel = new TokenModel();
           $tokenModel->setExpired_at($expiredAt)
                    ->setRefresh_token($refreshToken)
                    ->setToken($token)
                    ->setUsuario_id($usuario->getId());
            $refreshTokenDecoded = JWT::decode(
                $token,
                getenv('JWT_SECRET_KEY'),
                ['HS256']
            );
           //var_dump($refreshTokenDecoded);
           $tokenDAO = new TokenDAO();
           $tokenDAO->createToken($tokenModel);
           $response = $response->withJson([
               "token" => $token,
               "refresh_token" => $refreshToken,
              // "senha" => getenv('JWT_SECRET_KEY')
           ]);

                

           return $response;
    }
    public function refresh(Request $request,Response $response, array $args): Response
    {
           $data = $request->getParsedBody();
           
           $refreshToken = $data['refreshToken'];
           
          

           $response = $response->withJson([
               "refreshToken" => $refreshToken,
               
              // "senha" => getenv('JWT_SECRET_KEY')
           ]);

                

           return $response;
    }
    public function logout(Request $request,Response $response, array $args): Response
    {
           $data = $request->getParsedBody();
           
           $refreshToken = $data['refreshToken'];
           
          

           $response = $response->withJson([
               "mensagem" => "ok",
               

           ]);

                

           return $response;
    }
    public function message(Request $request,Response $response, array $args): Response
    {

           $response = $response->withJson([
               "message" => "Deu certo mensagem.",
               
              // "senha" => getenv('JWT_SECRET_KEY')
           ]);

                

           return $response;
    }

}