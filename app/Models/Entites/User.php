<?php 
namespace App\Models\Entites;
use App\Config\Database;

class User {
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $telephone;
    private $societe;
    private $error = [];


    public function __construct($nom, $prenom, $email, $password, $telephone, $societe) {
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->setTelephone($telephone);
        $this->setSociete($societe);
    }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getEmail() { return $this->email; }
    public function getPassword() { return $this->password; }
    public function getSociete() { return $this->societe; }
    public function getTelephone() { return $this->telephone; }
    public function getError() { return $this->error; }

    public function setError($error) {
        return array_push($this->error, $error);
    }    

    public function setNom($nom) {
        $this->nom = $nom;                
    }

    public function setPrenom($prenom) {
       $this->prenom = $prenom;
    }

    public function setEmail($email) {
        $verifBDD = $this->verifyEmail($email);
        $validation = $this->validateEmail($email);
        
        if ($verifBDD == true) {
            return $this->setError("L'email existe déjà !");
        }
        
        if ($validation == false ) {
            return $this->setError("L'email est invalide !");
        }
        
        $this->email = $email;
    }

    public function setPassword($password) {
        $password = $this->hashPassword($password);
        $this->password = $password;
    }

    public function setTelephone($telephone) {
       $this->telephone = $telephone;
    }

    public function setSociete($societe) {
        $this->societe = $societe;
    }



    public static function verifyEmail($email) {
        $value = findBy2 ('*', 't_users',  'email', $email);

        if (is_array($value) && count($value) >= 1) {
            return true;
        } else {
            return false;
        }
    }

    private function validateEmail($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
        return false;
        }
    }


    public function hashPassword($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public static function verifyPassword($password, $hash) {
        if (password_verify($password, $hash)) {
            return true;
        } else {
            return false;
        }
    }

}