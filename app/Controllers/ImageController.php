<?php
namespace App\Controllers;
use App\Models\Classes\Upload;

class ImageController 
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function index() {
        // Affichage de la liste de la galerie

        $pdo = $this->pdo;

        $navbar = buildNavbar('images');
        
        $titre = "Galerie d'images";
        
        $images = getAll($pdo, 't_images');
        
        ob_start();
        require dirname(__DIR__) . '/Views/galerie/index.image.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function show($id) {
        // Affichage du détail d'une image


    }

    public function create() {
        // Formulaire du téléchargement de l'image

        $pdo = $this->pdo;

        // Bloquer la page aux visiteurs
        require_login();

        $categories = getAll($pdo, 't_categories');
        $images = getAll($pdo, 't_images');

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $image = null;
        if ($id) {
            $image = findBy ($pdo, 't_images', 'id', $id);
            $image = $image[0] ?? null;
        }

        $titre = "Ajouter une image";

        ob_start();
        require dirname(__DIR__) . '/Views/galerie/edit.image.php';
        $content = ob_get_clean(); 
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function store() {
        // Traitement du téléchargement de l'image

        $pdo = $this->pdo;
        if (!empty($_POST) && $_SERVER["REQUEST_METHOD"] === "POST") {
            
            $nom = htmlspecialchars($_POST['nom']);
            $categorie = htmlspecialchars($_POST['categorie']);

            $N_C = findBy2($pdo, 'nom','t_categories', 'id', $categorie);
            $nom_categorie = $N_C['nom'];

            $upload = new Upload($_FILES['image']);

            if ($upload->validate()) {
                $uploadDir = 'uploads/';
                $uploadPath = dirname(__DIR__, 2) . '/public/uploads/';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true); // Crée le dossier avec les bonnes permissions
                }

                if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775,
                true)) {
                    header("Location: " . BASE_URL . "image/formulaire?erreur=Impossible de créer le dossier uploads principal !");
                    exit();
                }

                if (!is_writable($uploadPath)) {
                    die("Erreur : le dossier uploads n'est pas inscriptible par PHP !");
                }
        
                $categorieClean = preg_replace('/[^a-zA-Z0-9_-]/', '_', $nom_categorie);
                $categoriePath = $uploadPath . $categorieClean . '/';
                
                if (!is_dir($categoriePath)) {
                    mkdir($categoriePath, 0775, true); // Crée le dossier de la catégorie avec les bonnes permissions
                }
                
                if (!is_dir($categoriePath) && !mkdir($categoriePath, 0775, true)) {
                    header("Location: " . BASE_URL . "image/formulaire?erreur=Impossible de créer le dossier " . $categorieClean . "!");
                    exit();
                }

                if (!file_exists($_FILES['image']['tmp_name'])) {
                    die("Erreur : le fichier temporaire n'existe pas.");
                }

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('img_') . '.' . $ext;

                
                $destination = $categoriePath . $fileName;
                
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
            
            $categorieDir = $uploadDir . $categorieClean . '/';
            $imageUrl = $categorieDir . $fileName;

            $data = [
                'nom' => $nom,
                'image' => $imageUrl,
                'id_categorie' => $categorie
            ];
            var_dump($data);

            if (insert($pdo,'t_images', $data) !== false) {
                header("Location: " . BASE_URL . "image/formulaire?success=Image ajoutée avec succès !");
                exit;
            } else {
                header("Location: " . BASE_URL . "image/formulaire?erreur=L'image n'a pas pu être ajouté.") ;
                exit;
            }
        }
    }

    public function edit($id) {
        // Formulaire de modification

        $pdo = $this->pdo;

        // Bloquer la page aux visiteurs
        require_login();

        $categories = getAll($pdo, 't_categories');
        $images = getAll($pdo, 't_images');

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;

        $image = null;
        if ($id) {
            $image = findBy ($pdo, 't_images', 'id', $id);
            $image = $image[0] ?? null;
        }

        $titre = "Modifier une image";

        ob_start();
        require dirname(__DIR__) . '/Views/galerie/edit.image.php';
        $content = ob_get_clean(); 
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function update($id) {
        // Traitement du formulaire de modification (Mise-à-jour)

        
    }

     public function delete($id) {
        // Traitement de suppression de la donnée

        $pdo = $this->pdo;

        $id = $_GET['id'];

        if ($id) {
            $image = findBy1($pdo, 't_images', 'id', $id);
            $image = $image[0] ?? null;
            $imageNom = $image['nom'];
            
            if ($image) {
                if (delete($pdo, 't_images', $id) !== false) {
                    header('Location: ' . BASE_URL . 'user/dashboard?success=' . urlencode("Votre image $imageNom a été bien été supprimée."));
                    exit;
                } else {
                    header('Location: ' . BASE_URL . 'user/dashboard?erreur=' . urlencode("Une erreur s'est produite."));                    
                    exit;
                }
            } else {
                header('Location: ' . BASE_URL . 'user/dashboard?erreur=image introuvable.');
                exit;
            }
        } else {
            header('Location: ' . BASE_URL . 'user/dashboard?erreur=ID image manquant.');
            exit;
        }
    }
}