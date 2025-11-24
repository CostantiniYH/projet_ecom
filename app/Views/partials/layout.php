<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="auteur" content="YHC">
    <meta name="keywords" content="">    
    <title><?= $titre ?? 'Site YHC - ecommerce' ?></title>
    <link rel="icon" type="image/x-icon" href="https://img.freepik.com/vecteurs-premium/vaisseau-spatial-futuriste-metallise-noir-fond-planete-elements-rendu-3d-image-fournie_858664-4073.jpg">    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/hover.css/2.3.1/css/hover-min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>css/style.css">
    <?php
        if (isset( $_GET['id'])) {
            echo '<link rel="stylesheet" href="' . BASE_URL . 'css/style_card.css">';
        }
    ?>
</head>
<body>          
    <?php require_once __DIR__ . '/header.php'; ?>    

    <div class="">
        <?= $content ?? '' ;?>
    </div>    

    <?php require_once __DIR__ . '/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    
    <script  src="<?= BASE_URL ?>js/script.js"></script>

</body>
</html>    