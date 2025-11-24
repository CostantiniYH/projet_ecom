<header>
    <?php
    require_once __DIR__ . '/navbarBuilder.php'; 

    $navbar->render(); 
    
    
    $currentUrl = $_SERVER['REQUEST_URI'];

    // On retire les éventuels paramètres GET
    $currentPath = parse_url($currentUrl, PHP_URL_PATH);
    
    // On enlève BASE_URL si présent
    $relativePath = str_replace(BASE_URL, '', $currentPath);
    
    // On retire un éventuel slash final
    $relativePath = trim($relativePath, '/');
    
    // Si la page s'appelle "expertises", "services", etc.
    $currentPage = $relativePath ?: 'accueil';
        
    // Mise en forme pour affichage
    $currentPageLabel = ucfirst(str_replace('-', ' ', $currentPage)); 
    ?>

    <?php if ($currentPage === 'home' || $currentPage === 'accueil'): ?>
        <div class="carousel-container shadow position-relative rounded-bottom-5" style=" overflow: hidden; width: 100%; height: 20rem;"
        data-aos="zoom-in" data-aos-duration="1000">
            <?php
                $carousel = new App\Core\Carousel;
                $carousel->Read($a, 1);
            ?>
            <h1 class="position-absolute top-50 start-50 translate-middle w-100 h-100 shadow rounded-bottom-5 bg-dark bg-opacity-50 text-white">
                Bienvenue <br>sur <br>YHC Marketplace</h1>
        </div>  
    <?php endif; ?>

    <?php require __DIR__ . '/../components/alerts.php'; ?>
            
    <p class="container mt-5">
        <a class="text-dark" href="<?= BASE_URL ?>">Accueil</a>
        <?php if ($currentPage !== 'accueil') : ?>
            / <?= $currentPageLabel ?>
        <?php endif; ?>
    </p>
</header>