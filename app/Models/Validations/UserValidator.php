<?php
namespace App\Models\Validations;

// (2) La classe UserValidator() valide les données selon des conditions et vérifications, et retourne les erreurs,
// pas d'impact sur la classe UserEntite(), ni de hachage du mot de passe (Indépendante).

class UserValidator {
    public function validateRegistration($data) {
        $errors = [];

        if (empty($data['nom']) || strlen($data['nom']) < 3) {
            $errors['nom'] = "Le nom doit contenir au moins 3 caractères";
        }
        
        if (empty($data['prenom']) || strlen($data['prenom']) < 3) {
            $errors['prenom'] = "Le prénom doit contenir au moins 3 caractères";
        }

        if (strlen($data['telephone']) < 10) {
            $errors['telephone'] = "Le numéro de téléphone doit contenir au moins 10 chiffres !";
        }
        
        if (strlen($data['societe']) < 2) {
            $errors['societe'] = "La société doit contenir au moins 2 caractères !";
        }
       

        if (empty($data['password']) || strlen($data['password']) < 8) {
                $errors['password'] = "Le mot de passe doit contenir au moins 8 caractères";
            }
        return $errors;        
    }
}