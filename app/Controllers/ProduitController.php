<?php
namespace App\Controllers;
use App\Models\Entites\Produit;
use App\Models\Classes\Upload;

class ProduitController 
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


    public function index() {
        // Affichage de la liste des catégories

        $pdo = $this->pdo;

        $navbar = buildNavbar('produits');

        $id = $_GET['id'] ?? null;
        $produits = getAllWhere ($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ($pdo, 't_produits', 'id_categorie', $id); 
        
        $titre = "Produits";

        ob_start(); 
        require dirname(__DIR__) . '/Views/produits/index.produits.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function index2($id) {
        // Affichage de la liste des catégories

        $pdo = $this->pdo;

        $navbar = buildNavbar('produits');

        // $id = $_GET['id'] ?? null;
        $produits = getAllWhere ($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);
        $produitID = findBy ($pdo, 't_produits', 'id_categorie', $id); 
        
        $titre = "Produits";

        ob_start(); 
        require dirname(__DIR__) . '/Views/produits/index.produits.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function show($id) {
        // Affichage du détail d'un produit

        $pdo = $this->pdo;

        $navbar = buildNavbar('détail_produits');
        $one = findBy ($pdo, 't_produits', 'id', $id); 
        $one = $one[0];
        
        $titre = "Détails du produit";

        ob_start(); 
        require dirname(__DIR__) . '/Views/produits/show.produit.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function create() {
        // Formulaire de création du produit

        $pdo = $this->pdo;

        // Bloquer la page aux visiteurs
        require_login();

        $categories = getAll($pdo, 't_categories');
        $produits = getAllWhere($pdo, 't_produits', 'deleted_at IS NULL AND quantite > ?', 0);

        $id = isset($_GET['id']) ? intval($_GET['id']) : null;  // Sécurisation

        $produit = null;
        if ($id) {
            $produit = findBy($pdo, 't_produits', 'id', $id);
            $produit = $produit[0] ?? null; // Vérifier si le produit existe
            if (!$produit || empty($produit)) {
                die("Produit introuvable.");
            }
        }
        $navbar = buildNavbar('form_produit');

        $titre = "Formulaire Produit";

        ob_start(); 
        require dirname(__DIR__) . '/Views/produits/edit.produit.php';
        $content = ob_get_clean();
        require dirname(__DIR__) . '/Views/partials/layout.php';
    }

    public function store() {
        // Traitement des données de la création du produits

        $pdo = $this->pdo;
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $nom = htmlspecialchars($_POST['nom']);
            $prix = htmlspecialchars($_POST['prix']);
            $devise = htmlspecialchars($_POST['devise']);
            $quantite = htmlspecialchars($_POST['quantite']);
            $description = htmlspecialchars($_POST['description']);
            $categorie = htmlspecialchars($_POST['categorie']);
            $userId = htmlspecialchars($_POST['id_user']);
            
            $N_C = findBy2($pdo, 'nom','t_categories', 'id', $categorie);
            $nom_categorie = $N_C['nom'];
        
            $produit = new Produit($nom, $prix, $devise, $quantite, $categorie, $description);

            $upload = new Upload($_FILES['image']);
            if ($upload->validate()) {
                $uploadDir = 'uploads/';
                $uploadPath = dirname(__DIR__, 2) . '/public/uploads/';


                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true); // Crée le dossier avec les bonnes permissions
                }

                if (!is_dir($uploadPath) && !mkdir($uploadPath, 0775,
                true)) {
                    header('Location: ' . BASE_URL . 'produit/formulaire?erreur=Impossible de créer le dossier 
                    uploads principal !');
                    exit;
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
                    header('Location: ' . BASE_URL . 'produit/formulaire?erreur=Impossible de créer le dossier ' . $categorieClean . '!');
                    exit;
                }                

                if (!file_exists($_FILES['image']['tmp_name'])) {
                    die("Erreur : le fichier temporaire n'existe pas.");
                }

                $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('img_') . '.' . $ext;
                $destination = $categoriePath . '/' . $fileName;    
                
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
                'nom' => $produit->getNom(),
                'prix' => $produit->getPrix(),
                'devise' => $produit->getDevise(),
                'quantite' => $produit->getQuantite(),
                'description' => $produit->getDescription(),
                'id_categorie' => $produit->getCategorie(),
                'image' => $imageUrl,
                'id_user' => $userId
            ];   

            if (insert($pdo,'t_produits', $data) !== false) {
                header('Location: ' . BASE_URL . 'produit/formulaire?success=Produit ajouté avec succès !');
                exit;
            } else {
                header('Location: ' . BASE_URL . 'produit/formulaire?erreur=Le produit n\'a pas pu être ajouté.' ) ;
                exit;
            }
        }
    }


    public function edit($id) {
        // Formulaire de modification

        $titre = "";

        ob_start();
        require dirname(__DIR__) . "Views/produits/edit.produit.php";
        $content = ob_get_clean();
        require dirname(__DIR__) . "Views/partials/layout.php";
    }

    public function update($id) {
        // Traitement du formulaire de modification (Mise-à-jour)

        
    }

     public function delete($id) {
        // Traitement de suppression de la donnée

        $pdo = $this->pdo;

        $id = $_GET['id'];

        if ($id) {
            $produit = findBy1($pdo, 't_produits', 'id', $id);
            $produit = $produit[0] ?? null;
            $produitNom = $produit['nom'];
            
            if ($produit) {
                delete($pdo, 't_produits', $id, true);
                if (isAdmin()) {
                    header('Location: ' . BASE_URL . 'admin/dashboard.php?success=' . urlencode("Produit $produitNom supprimé avec succès !"));
                } else {
                    header('Location: ' . BASE_URL . 'user/dashboard.php?success=' . urlencode("Votre produit $produitNom a été supprimé avec succès !"));
                }
                exit();
            } else {
                header('Location: ' . BASE_URL . 'user/dashboard.php?erreur=Produit introuvable.');
                exit();
            }
        } else {
            header('Location: ' . BASE_URL . 'user/dashboard.php?erreur=ID produit manquant.');
            exit();
        }
    }
}
