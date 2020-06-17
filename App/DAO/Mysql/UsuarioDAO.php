<?php 

namespace App\DAO\Mysql;
use App\Modals\UsuarioModel;

class UsuarioDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUserByEmail(string $email): ?UsuarioModel
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    id,
                    nome,
                    email,
                    senha
                FROM usuario
                WHERE email = :email;
            ');
        $statement->bindParam('email', $email);
        $statement->execute();
        $usuarios = $statement->fetchAll(\PDO::FETCH_ASSOC);
        if(count($usuarios) === 0)
            return null;
        $usuario = new UsuarioModel();
        $usuario->setId($usuarios[0]['id'])
            ->setNome($usuarios[0]['nome'])
            ->setEmail($usuarios[0]['email'])
            ->setSenha($usuarios[0]['senha']);
        return $usuario;
    }
    public function insertUsuario(UsuarioModel $usuario): void
    {
        $statement = $this->pdo
                        ->prepare('INSERT INTO usuario (nome, email, senha) VALUES (
                            :nome, 
                            :email, 
                            :senha
                        );');
        $statement->execute([
                    'nome' => $usuario->getNome(),
                    'email' => $usuario->getEmail(),
                    'senha' => $usuario->getSenha()
        ]);

                        
    }
    public function updateUsuario(UsuarioModel $usuario): void
    {

        $statement = $this->pdo
                        ->prepare('UPDATE usuario SET 
                        nome=:nome, 
                        email=:email, 
                        senha=:senha 
                        WHERE id=:id');
        $statement->execute([
                    'nome' => $usuario->getNome(),
                    'email' => $usuario->getEmail(),
                    'senha' => $usuario->getSenha(),
                    'id' => $usuario->getId()
        ]);

                        
    }
    public function deleteUsuario($id): void
    {
        $statement = $this->pdo
                ->prepare('DELETE FROM usuario WHERE id=:id');
        $statement->execute([
            'id' => $id
            ]);
    }
    public function getAllUsuarios(): array{
        $usuarios = $this->pdo
            ->query('SELECT id,
                            nome,
                            email 
                    FROM usuario;')
            ->fetchAll(\PDO::FETCH_ASSOC);
            return $usuarios;
    } 

}