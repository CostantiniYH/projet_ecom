<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Classes\Upload;
use App\Config\BD;


class AuthController 
{
    public function loginGet() {
        $navbar = authNavbar('login');
        $titre = "Connexion";
        ob_start(); 
        require_once __DIR__ . '/../Views/auth/login.form.php';       
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/partials/layout.php';
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
        $navbar = authNavbar('register');
        $titre = "Inscription";
        $user = null;
        $id = null;
        ob_start(); 
        require_once __DIR__ . '/../Views/auth/register.form.php';       
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/partials/layout.php';
    }

    public function registerPost() {
        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        $user = null;
        if ($id) {
            $user = findBy1 ('t_users', 'id', $id);
            $user = $user[0] ?? null;
        }

        $nom = $_POST['nom'] ?? "";
        $prenom = $_POST['prenom'] ?? "";
        $telephone = $_POST['telephone'] ?? "";
        $societe = $_POST['societe'] ?? "";

        $email = $_POST['email'] ?? "";
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        
        $password = $_POST['password'] ?? "";
        $passwordConfirm = $_POST['password2'] ?? "";
        if ($password !== $passwordConfirm) {
            header('Location: ' . BASE_URL . 'register?message=Les mots de passe ne correspondent pas.');
            exit();
        }
        
        $user = new User($nom, $prenom, $email, $password, $telephone, $societe);
        $error = $user->getError();
        if (!empty($error)) {
            header('Location: ' . BASE_URL . 'register?erreur=' . urlencode($error[0]));
            exit();
        }
        
        $upload = new Upload($_FILES['image']);
        if ($upload->validate()) {
            [$dest, $imageUrl] = explode(';', $upload->getDestAndUrl($user));
            $upload->moveTo($dest);
        } else {
            header( 'Location: ' . BASE_URL . 'register?erreur=Erreur de validation : '. implode(', ', $upload->getError())  ) ;
            exit();
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
            header('Location: ' . BASE_URL . 'register?success=Votre profil a été mis à jour avec succès !');
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