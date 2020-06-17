<?php

namespace App\DAO\Mysql\Store;
use App\Modals\TokenModel;

class TokenDAO extends Conexao
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createToken(TokenModel $token): void
    {
        $statement = $this->pdo
            ->prepare('INSERT INTO token
                (
                    token,
                    refresh_token,
                    expired_at,
                    usuario_id
                )
                VALUES
                (
                    :token,
                    :refresh_token,
                    :expired_at,
                    :usuario_id
                );
            ');
        $statement->execute([
            'token' => $token->getToken(),
            'refresh_token' => $token->getRefresh_token(),
            'expired_at' => $token->getExpired_at(),
            'usuario_id' => $token->getUsuario_id()
        ]);
    }

    public function verifyRefreshToken(string $refreshToken): bool
    {
        $statement = $this->pdo
            ->prepare('SELECT
                    id
                FROM token
                WHERE refresh_token = :refresh_token;
            ');
        $statement->bindParam('refresh_token', $refreshToken);
        $statement->execute();
        $tokens = $statement->fetchAll(\PDO::FETCH_ASSOC);
        return count($tokens) === 0 ? false : true;
    }
}