<?php
namespace App\Controllers;
use App\Models\Classes\Upload;

use PDO;
use PDOException;

class CategorieController 
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index() {
        $pdo = $this->pdo;
        $navbar = buildNavbar('categories');
        $titre = "Catégories";
        
        function getAllCategoriesWithProductCount($pdo) {
        try {
            $sql = "SELECT c.id, c.nom, c.image, COUNT(p.id) AS nombre_produits
            FROM t_categories c
            LEFT JOIN t_produits p ON p.id_categorie = c.id
            GROUP BY c.id, c.nom
            ORDER BY c.nom ASC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
        $categories = getAllCategoriesWithProductCount($pdo);
        ob_start();
        require dirname(__DIR__) . '/Views/categories/index.categories.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function show($id) {

    }

    public function create() {
        $pdo = $this->pdo;

        require_login();

        if (!isAdmin()) {
            echo "Accès interdit !";
            exit;
        }

        $categories = getAll($pdo, 't_categories');

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $categorie = null;
        if ($id) {
            $categorie = findBy1 ($pdo, 't_categories', 'id', $id);
            $categorie = $categorie[0] ?? null;
        }
        $titre = "Ajouter/modifier une catégorie";

        ob_start();
        require dirname(__DIR__) . "/Views/categories/edit.categorie.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "/Views/partials/layout.php";
    }

    public function store() {
        $pdo = $this->pdo;

        // Bloquer le traitement si la méthode HTTP n'est pas  POST
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            
            // Récupérer les données envoyés par l'utilisateur : le nom et le fichier de l'image
            $categorie = htmlspecialchars($_POST['nom']);
            $upload = new Upload($_FILES['image']);

            // Après l'instanciation de l'objet Upload, vérifier s'il n'y a pas d'erreur avec la méthode validate
            if ($upload->validate()) {
                $uploadDir = 'uploads/';
                $uploadPath = dirname(__DIR__, 2) . '/public/uploads/';

                // Si le répertoire uploads/ n'existe pas, créer le répertoire immédiatement
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0775, true); 
                }

                // Si le répertoire ne se crée pas, rediriger et retourner une erreur à l'utilisateur
                if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775, true)) {
                    header("Location: " . BASE_URL . "categorie/formulaire?erreur=Impossible de créer le dossier uploads principal !");
                    exit();
                }

                // S'il est impossible d'écrire dans le dossier uploads/, retourner une erreur aux développeurs
                if (!is_writable($uploadPath)) {
                    die("Erreur : le dossier uploads n'est pas inscriptible par PHP !");
                }
        
                // Nettoyer le nom de la categorie afin qu'il corresponde aux standards de nommage de répertoire (sans espace 
                // ni carractère spéciaux) et ajouter une majuscule à la première lettre
                $categorieClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $categorie);
                $categoriePath = $uploadPath . $categorieClean . '/';

                // Comme pour le répertoire uploads/, si le dossier de la catégorie n'existe pas, le créer maintenant :
                if (!is_dir($categoriePath)) {
                    mkdir($categoriePath, 0775, true);
                }
                
                // Si on ne paut pas le créer à cause des permissions, rediriger l'utilisateur et lui envoyer une erreur :
                if (!is_dir($categoriePath) && !mkdir($categoriePath, 0775, true)) {
                    header('Location: ' . BASE_URL . 'categorie/formulaire?erreur=Impossible de créer le dossier ' . $categorieClean . '!');
                    exit();
                }

                
                if (!file_exists($_FILES['image']['tmp_name'])) {
                    die("Erreur : le fichier temporaire n'existe pas.");
                }
                
                // Extraire l'extension du fichier
                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                
                // Générer un nom de fichier commençant par img_ + identifiant puis ajouter l'extension :
                $fileName = uniqid('img_') . '.' . $ext;

                // Préparer le chemin dans lequel le fichier sera déplacer
                $destination = $categoriePath . '/' . $fileName;
                 
                // Préparer le chemin final stocké en BDD en 2 temps : le dossier puis dossiers + fichier
                $categorieDir = $uploadDir . $categorieClean . '/';
                $imageUrl = $categorieDir . $fileName;
                    
                // Mettre les données du formulaire dans un tableau :
                $data = [
                    'nom' => $categorieClean,
                    'image' => $imageUrl
                    ];            
                    

                // On insère tout de suite afin de ne pas télécharger le fichier si l'enregistrement en BDD
                // échoue :
                if (insert($pdo,'t_categories', $data) == true) {
                    header("Location: " . BASE_URL . "categorie/formulaire?success=Catégorie ajoutée avec succès !");
                    exit();
                } else {
                    header( "Location: " . BASE_URL . "categorie/formulaire?erreur=La catégorie n'a pas pu être ajoutée.");
                    exit();
                }
                
                if ($upload->moveTo($destination)) {
                    echo "Fichier uploadé avec succès ! <br>";
                    echo "Chemin du fichier : " . $upload->getFilePath();
                } else {
                    $erreurMove = "Erreur lors du déplacement du fichier : " . implode(', ', $upload->getError());
                    header('Location: ' . BASE_URL . 'categorie/formulaire?erreur=' . $erreurMove . '' ) ;
                    exit();
                }
            } else {
                $erreurValidation = "Erreur de validation : " . implode(', ', $upload->getError());
                header('Location: ' . BASE_URL . 'categorie/formulaire?erreur=' . $erreurValidation . '' ) ;
                exit();
            } 
        }
    }

     public function edit($id) {
        $titre = "";

        ob_start();
        require dirname(__DIR__) . "Views/categorie/edit.categorie.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "Views/partials/layout.php";
    }

     public function update($id) {
        $titre = "";

        ob_start();
        require dirname(__DIR__) . "Views/categorie/edit.categorie.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "Views/partials/layout.php";
    }
    public function delete($id) {        
        $pdo = $this->pdo;

        $id = $_GET['id'];

        if ($id) {
            $categorie = findBy1($pdo, 't_categories', 'id', $id);
            $categorie = $categorie[0] ?? null;
            $categorieNom = $categorie['nom'];
            
            if ($categorie) {
                delete($pdo, 't_categories', $id);
            // var_dump(delete($connect, 't_categories', $id, true));
            // exit();
                if (isAdmin()) {
                    header('Location: ' . BASE_URL . 'admin/dashboard.php?success=' . urlencode("categorie $categorieNom supprimé avec succès !"));
                } else {
                    header('Location: ' . BASE_URL . 'compte/dashboard.php?success=' . urlencode("Votre categorie $categorieNom a été supprimé avec succès !"));
                }
                exit();
            } else {
                header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=categorie introuvable.');
                exit();
            }
        } else {
            header('Location: ' . BASE_URL . 'compte/dashboard.php?erreur=ID categorie manquant.');
            exit();
        }
    }
}