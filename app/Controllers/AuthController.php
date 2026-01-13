<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Classes\Upload;

class AuthController 
{
    public function loginGet() {
        afficher('login', 'Connexion', 'auth/login.form');
    }

    public function loginPost() {
        $email = $_POST['email'] ?? '';
        $value = User::verifyEmail($email);
        if ($value === false) {
            header('Location: /login?erreur=L\'utilisateur n\'existe pas.');
            exit();
        }
        
        $password = $_POST['password'] ?? '';
        $password_hash = $value['password'];
        if (User::verifyPassword($password, $password_hash)) {
            loginUser($value);
            if (isAdmin()) {
                header('Location: /dashboard_admin?success=Vous êtes connecté en tant qu\'administrateur.');
                exit;
            } 
            header ('Location: /dashboard?success=Connexion réussi !');
            exit;
        } else {
            header('Location: /login?erreur=Le mot de passe est incorrecte !');
            exit;
        }
    }

    public function registerGet() {
        $id = null;
        $user = null;
        extract($_GET);
        if ($url === 'moi') {
            $id = $_SESSION['user']['id'];
            $user = $_SESSION['user'];
        }
        $data = [
            'id' => $id,
            'user' => $user
        ];
        afficher('register', 'Inscription', 'auth/register.form', $data);
    }

    public function registerPost() {
        extract($_GET);
        if ($url === 'moi') {
            $id = $_SESSION['user']['id'];
            $user2 = findBy1( 't_users', 'id', $id);
            $password = ($user2[0]['password']);
            $password2 = $password;
        }
        extract($_POST);
        $user = new User($nom, $prenom, $email, $password, $password2, $telephone, $societe);
        $error = $user->getError();
        if (!empty($error)) {
            header('Location: ' . BASE_URL . 'register?erreur=' . urlencode($error[0]));
            exit();
        }
        
        $upload = new Upload($_FILES['image']);
        if ($upload->validate() === true) {
            [$dest, $imageUrl] = explode(';', $upload->getDestAndUrl($user));
            $upload->moveTo($dest);
        } else {
            if (!empty($id)) {
                $imageUrl = ($user2[0]['photo']);
            } else {
                header( 'Location: ' . BASE_URL . 'register?erreur=Erreur de validation : '. implode(', ', $upload->getError())  ) ;
                exit();
            }
        }

        $data = [
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'telephone' => $user->getTelephone(),
            'societe' => $user->getSociete(),
            'photo' => $imageUrl
        ];
        
        if (!empty($id)) {
            $data['id'] = $id;
            update('t_users', $data, 'id', $id);
            header('Location: ' . BASE_URL . 'dashboard?success=Votre profil a été mis à jour avec succès !');
            $_SESSION['user'] = [
                'id' => $data['id'],
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'telephone' => $data['telephone'],
                'societe' => $data['societe'],
                'photo' => $data['photo'],
                'role' => $data['role'],
            ];
        } else {
            insert('t_users', $data);
            header('Location: ' . BASE_URL . 'register?success=Utilisateur ajouté avec succès !');
        }
    }

    public function logout() {
        require_once __DIR__ . '/../coreTemp/session.php';
        logoutUser();
    }
}