<?php
namespace App\Models\Requetes;
use PDO;

class UserModel extends Model 
{
    public function __construct($pdo) 
    {
        return parent::__construct($pdo);
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM t_users WHERE email = :email";
        $stmt = $this->query($sql, ['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}