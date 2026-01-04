<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Classes\Upload;
use App\Config\BD;


class AuthController 
{
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $navbar = authNavbar('login');
            $titre = "Connexion";
            ob_start(); 
            require_once __DIR__ . '/../Views/auth/login.form.php';       
            $content = ob_get_clean();
            require_once __DIR__ . '/../Views/partials/layout.php';
            exit();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $value = User::verifyEmail($email);

        if ($value === false) {
            header('Location: /login?erreur=L\'utilisateur n\'existe pas.');
            exit();
        }

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

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $navbar = authNavbar('register');
            $titre = "Inscription";
            $user = null;
            $id = null;
            ob_start(); 
            require_once __DIR__ . '/../Views/auth/register.form.php';       
            $content = ob_get_clean();
            require_once __DIR__ . '/../Views/partials/layout.php';
            exit();
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : null;
        $user = null;
        if ($id) {
            $user = findBy1 ('t_users', 'id', $id);
            $user = $user[0] ?? null;
        }
        $nom = $_POST['nom'] ?? "";
        $prenom = $_POST['prenom'] ?? "";
        $email = $_POST['email'] ?? "";
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? "";
        $passwordConfirm = $_POST['password2'] ?? "";
        $telephone = $_POST['telephone'] ?? "";
        $societe = $_POST['societe'] ?? "";
        
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
            $uploadDir = 'uploads/';
            $uploadPath = __DIR__ . '/../../uploads/';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true); // Crée le dossier avec les bonnes permissions
            }

            if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775,
            true)) {
                header('Location: ' . BASE_URL . 'register?erreur=Impossible de créer le dossier 
                uploads principal !');
                exit();
            }

            if (!is_writable($uploadPath)) {
                die("Erreur : le dossier uploads n'est pas inscriptible par PHP !");
            }

            $userDir = $user->getNom() . '_' . $user->getPrenom();
    
            $userClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $userDir);
            $userPath = $uploadPath . $userClean . '/';
            
            if (!is_dir($userPath)) {
                mkdir($userPath, 0775, true); // Crée le dossier de la catégorie avec les bonnes permissions
            }
            
            if (!is_dir($userPath) && !mkdir($userPath, 0775, true)) {
                header('Location: ' . BASE_URL . 'register?erreur=Impossible de créer le dossier ' . $categorieClean . '!');
                exit();
            }

            if (!file_exists($_FILES['image']['tmp_name'])) {
                die("Erreur : le fichier temporaire n'existe pas.");
            }

            $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $fileName = uniqid('img_') . '.' . $ext;

            $destination = $userPath . $fileName;
            
            if ($upload->moveTo($destination)) {
                echo "Fichier uploadé avec succès ! <br>";
                echo "Chemin du fichier : " . $upload->getFilePath();
            } else {
                echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
                exit();
            }
        } else {
            header( 'Location: ' . BASE_URL . 'register?erreur=Erreur de validation : '. implode(', ', $upload->getError())  ) ;
            exit();
        } 
        
        $imageUrl = $uploadDir . $userClean . '/' . $fileName;
        
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
            $update = update('t_users', $data, 'id', $id);
            
            if ($update) {
                header('Location: ' . BASE_URL . 'register?success=Votre profil a été mis à jour avec succès !');
                exit();
            } else {
                header( 'Location: ' . BASE_URL . 'register?erreur=Erreur lors de la modification de votre profil.' ) ;
                exit();
            }
        } else {
            insert('t_users', $data);
            
            header('Location: ' . BASE_URL . 'register?success=Utilisateur ajouté avec succès !');
            exit();
        }
    }

    public function logout() {
        require_once __DIR__ . '/../coreTemp/session.php';
        logoutUser();
    }
}