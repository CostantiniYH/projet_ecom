<?php
namespace App\Models\Services;
use App\Models\Entites\UserEntite;

// (4) Cette classe UserService gère toute la logique métier y compris la validation côté client du formulaire
// que nous avons écrit dans UserValidator.
// Logique métier de UserService :
// 1. Validation formulaire via UserValidator. 2. Création de l'objet via UserEntite
// 3. Hachage du password. 4. insertion BDD via UserModel.

class UserService {
    private $model;
    private $validator;

    public function __construct($model, $validator) {
        $this->model = $model;
        $this->validator = $validator;

    }

    public function register($data) {

        // (1)
        $errors = $this->validator->validateRegistration($data);
        if (!empty($errors)) {
            return $errors;
        }

        if ($this->model->findByEmail($data['email'])) {
            return ['email' => 'Cet emeil existe déjà dans la BDD.'];
        }

        // (2)
        $user = new UserEntite();

        $user->set_name($data['nom']);
        $user->set_email($data['email']);

        // (3)
        $user->set_password(password_hash($data['password'], PASSWORD_ARGON2ID));

        $user->set_role($data['role']);

        // (4)
        $this->model->insert($user);

        return [];
    }

    public function getAllUsers()
    {
        return $this->model->findAll();
    }
}