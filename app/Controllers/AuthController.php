<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Classes\Upload;


class AuthController 
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function formLogin() {
         $navbar = authNavbar('login');

        $titre = "Connexion";

        ob_start(); 
        require_once __DIR__ . '/../Views/auth/login.php';       
        $content = ob_get_clean();
        require_once __DIR__ . '/../Views/partials/layout.php';
    }


    public function login() {    
        $pdo = $this->pdo; 
        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $value = User::verifyEmail($email);

            if (is_array($value) && count($value) == 0) {
                header("Location: " . BASE_URL . "login?erreur=L'utilisateur n'existe pas.");
                exit();
            }
            var_dump($value);
            
            $user = findBy1($pdo, "t_users", "email", $email);
            var_dump($user);

            $password_hash = $user['password'];
            var_dump($password_hash);

            if (User::verifyPassword($password, $password_hash)) {
                loginUser($user);
                var_dump(loginUser($user)); ;
                if (isAdmin()) {
                    header("Location: " . BASE_URL . "admin/dashboard?success=Vous êtes connecté en tant qu'administrateur.");
                    exit;
                } 
                header ("Location: " . BASE_URL . "dashboard?success=Connexion réussi !");
                exit;
            } else {
                header("Location: " . BASE_URL . "login?erreur=Le mot de passe est incorrecte !");
                exit;
            }
        }
    }


    public function formRegister() {
        $pdo = $this->pdo;
        $navbar = authNavbar('register');

        $titre = "Inscription";

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $user = null;
        if ($id) {
            $user = findBy1 ($pdo, 't_users', 'id', $id);
            $user = $user[0] ?? null;
        }

        ob_start(); 
        require dirname(__DIR__) . '/Views/auth/register.php';       
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function register() {
        $pdo = $this->pdo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $id = $_POST['id'] ?? null;  
            $nom = trim(htmlspecialchars($_POST['nom']));
            $prenom = trim(htmlspecialchars($_POST['prenom']));
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = trim($_POST['password']);
            $passwordConfirm = trim($_POST['password2']);
            $telephone = trim(htmlspecialchars($_POST['telephone']));
            $societe = trim(htmlspecialchars($_POST['societe']));
            
            if ($password !== $passwordConfirm) {
                header('Location: ' . BASE_URL . 'auth/register?message=Les mots de passe ne correspondent pas !');
                exit();
            }
            
            $user = new User($nom, $prenom, $email, $password, $telephone, $societe);
            
            $error = $user->getError();
            
            if (!empty($error)) {
                header('Location: ' . BASE_URL . 'auth/register?erreur=' . urlencode($error[0]));
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
                    header('Location: ' . BASE_URL . 'auth/register?erreur=Impossible de créer le dossier 
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
                    header('Location: ' . BASE_URL . 'auth/register?erreur=Impossible de créer le dossier ' . $userClean . '!');
                    exit();
                }

                if (!file_exists($_FILES['image']['tmp_name'])) {
                    die("Erreur : le fichier temporaire n'existe pas.");
                }

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('img_') . '.' . $ext;

                $destination = $userPath . '/' . $fileName;
                
                if ($upload->moveTo($destination)) {
                    echo "Fichier uploadé avec succès ! <br>";
                    echo "Chemin du fichier : " . $upload->getFilePath();
                } else {
                    echo "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
                    exit();
                }
            } else {
                echo "Erreur de validation : " . implode(', ', $upload->getError());
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
                
                $update = update($pdo, 't_users', $data, 'id', $id);
                
                if ($update) {
                    header("Location: " . BASE_URL . "user/dashboard?success=Votre profil a été mis à jour avec succès !");
                    exit();
                } else {
                    echo "Erreur lors de la modification de votre profil !";
                    exit();
                }
            } else {   
                insert($pdo,'t_users', $data);
                
                header("Location: " . BASE_URL . "auth/login?success=Votre compte utilisateur a été créé avec succès !");
                exit();
            } 
        } else {
            header( "Location: " . BASE_URL . "auth/register?erreur=Le compte n'a pas pu être créé." ) ;
            exit();
        }
    }

    public function logout() {
        require __DIR__ . '/../coreTemp/session.php';
        logoutUser();
    }
}