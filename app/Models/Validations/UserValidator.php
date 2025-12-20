<?php
namespace App\Models\Validations;

// (2) La classe UserValidator() valide les données selon des conditions et vérifications, et retourne les erreurs,
// pas d'impact sur la classe UserEntite(), ni de hachage du mot de passe (Indépendante).

class UserValidator {
    public function validateRegistration($data) {
        $errors [];

        if (empty($data['nom']) || strlen($data['nom']) < 3) {
            return $this->setError("Le nom doit contenir au moins 3 caractères");
        }
        
        if (empty($data['prenom']) || strlen($data['prenom']) < 3) {
            return $this->setError("Le prénom doit contenir au moins 3 caractères");
        }

        if (strlen($telephone) < 10) {
            return $this->setError("Le numéro de téléphone doit contenir au moins 10 chiffres !");
        }
        
        if (strlen($societe) < 2) {
            return $this->setError("La société doit contenir au moins 2 caractères !");
        }
       

        if (empty($data['password']) || strlen($password) < 8) {
            return $this->setError("Le mot de passe doit contenir au moins 8 caractères");
        }
        
        
    }
}