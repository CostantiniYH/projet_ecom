<?php
namespace App\Models\Services;

class LoginService 
{
    private $model;
    private $validator;
    public function __construct($model, $validator)
    {
        $this->model = $model;
        $this->validator = $validator;
    }

    public function login($data)
    {
        $errors = $this->validator->validateLogin($data);
        if (!empty($errors)) {
            return $errors;
        }

        $user = $this->model->findByEmail($data['email']);
        if (!$user) {
            return ['errors' => ['email' => "Aucun compte ne correspond à cet email."]];
        }

        if (!password_verify($data['password'], $user['password'])) {
            return ['errors' => ['password' => "Le mot de passe est incorrect."]];
        }

        return ['user' => [$user]];        
    }
}