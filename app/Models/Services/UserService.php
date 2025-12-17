<?php
namespace App\Models\Services;
use App\Models\Entites\User;

class UserService
{
    private $model;
    private $validator;

    public function __construct($model, $validator) {
        $this->validator = $validator;
        $this->model = $model;
    }

    public function registerUser($data) {
        $errors = $this->validator->validateRegistration($data);
        if (!empty($error)) {
            return $errors;
        }

        $emailExiste = $this->model->getUserByEmail($data['email']);
        if (!empty($emailExiste)) {
            return ['email' => 'Vous ne pouvez pas choisir cet email car il est déjà associé à un compte. Veuillez choisir un autre email ou connectez-vous.'];
        }

        $user = new User();
    }
}