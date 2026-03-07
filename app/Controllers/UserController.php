<?php
namespace App\Controllers;
use App\Models\Entites\User;
use App\Models\Classes\Upload;

class UserController
{
    private $pdo;
    public function __construct($pdo) {

        $this->pdo = $pdo;
    }

    public function dashboard()  {
        // Tableau de bord de l'utilisateur

        // Bloquer la page aux visiteurs
        require_login();

        if (!isset($_SESSION['user'])) {
            die("Erreur : utilisateur non connecté.");
        } 

        $navbar = buildNavbar("Dashboard");
        $id = $_SESSION['user']['id'];
        $user = $_SESSION['user'];        
        $myProduits = findBy($this->pdo, 't_produits', 'id_user', $id);
        $myImages = findImageBy2($this->pdo, $id);
        
        $titre = "Dashboard";
        
        ob_start();
        require dirname(__DIR__) . '/Views/users/dashboard.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }


    public function edit($id) {
        // Modifier le profil

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


    public function update($id) {
        // Traitement de la modification
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
                $uploadPath = dirname(__DIR__, 2) . '/public/uploads/';

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
                    exit;
                } else {
                    $e = "Erreur lors de la modification de votre profil !";
                    header("Location: " . BASE_URL . "user/edit?erreur=$e");
                    exit;
                }
            } 
        } else {
            header( "Location: " . BASE_URL . "user/edit?erreur=Veillez remplir le formulaire normalement !" ) ;
            exit;
        }
    }

    public function delete($id) {        
        $pdo = $this->pdo;

        // Récupérer l'id de l'utilisateur de l'url ou de la session
        $id = $_GET['id'];

        // Si l'étape précédante est ok, récupérer la ligne correspondante de la base de données
        if ($id) {
            $user = findBy1($pdo, 't_users', 'id', $id);
            $user = $user[0] ?? null;
            
            // Si c'est ok, procéder à la suppression
            if ($user) {

                // S'il n'y a pas d'erreur au moment de la requête, rediriger l'utilisateur au bon endroit
                if (delete($pdo, 't_users', $id, true) !== false) {
                    if (isAdmin() && $_SESSION['user'] !== 'admin') {
                        header("Location: " . BASE_URL . "admin/dashboard?success=L'tilisateur a bien été supprimé.");
                    } else {
                        header("Location: " . BASE_URL . "auth/login?message=Votre profil a bien été supprimé.");
                        exit;
                    }
                } else {
                    header("Location: " . BASE_URL . "auth/login?erreur=Une erreur s'est produite lors de la suppression.");
                    exit;
                }
            } else {
                header("Location: " . BASE_URL . "auth/login.php?erreur=Utilisateur introuvable.");
                exit;
            }
        } else {
            header("Location: " . BASE_URL . "auth/login.php?erreur=ID utilisateur manquant.");
            exit;
        }

    }

}