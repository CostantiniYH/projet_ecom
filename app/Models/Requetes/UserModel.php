<?php
namespace App\Models\Requetes;

use App\Config\BD;
use PDO;

class UserModel extends Model 
{
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM t_users WHERE email = :email";
        $stmt = BD::co()->query($sql, ['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}