<?php
namespace App\Models\Validations;

// (2) La classe UserValidator() valide les données selon des conditions et vérifications, et retourne les erreurs,
// pas d'impact sur la classe UserEntite(), ni de hachage du mot de passe (Indépendante).

class UserValidator {
    public function validateRegistration($data) {
        $errors = [];

        if (empty($data['nom']) || strlen($data['nom']) < 3) {
            $errors['nom'] = "Le nom doit être supérieur à 3 caractères.";
        }

        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email invalide.";
        }

        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = "Veuillez entrer un mot de passe d'au moins 8 caractère.";
        }

        if ($data['password'] !== $data['confirm_password']) {
            $errors['password'] = "Les mots de passes ne correspondent pas !";
            header('Location: /register');
            exit();            
        }

        if (empty($data['role'])) {
            $errors['role'] = "Le rôle est obligatoire, veuillez choisir un rôle dans la sélection.";
        }

        return $errors;
    }

    public function validateLogin($data) 
    {
        $errors = [];

        if (empty($data['email'])) {
            $errors['email'] = "L'email est obligatoire.";
        }
        
        if (empty($data['password'])) {
            $errors['password'] = "Le mot de passe est obligatoire.";
        }

        return $errors;
    }

}