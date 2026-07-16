<?php

namespace app\models;

use App\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function findByEmail(string $email): array|false
    {
        return $this->db
            ->query(
                "SELECT * FROM users WHERE email = ? LIMIT 1",
                [$email]
            )
            ->fetch();
    }
}