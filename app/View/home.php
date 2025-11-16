<div class="container mb-5 mt-5" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="1000">
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">
        Bienvenue sur || YHC ||</h1>
        
    <div class="carousel-container shadow mb-5 rounded-4" style="overflow: hidden; width: 100%; height: 20rem;"
     data-aos="zoom-in" data-aos-duration="1000" data-aos-delay="1000">
        <?php
            $carousel = new App\classes\Carousel;
            $carousel->Read($a, 1);
        ?>
    </div>            
    <div class="row">
        <div class="col-md-4  mb-5 img-map img-index" style="height: 200px; overflow: hidden;"  data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Produits/magasin.jpg" class="card-img rounded-4 shadow" alt="Produits" usemap="#produitMap">
            <map name="produitMap">
            <area shape="rect" coords="0, 0, 350,250" alt="Produits" href="produits.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index " style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Categories/categories.jpg" class="card-img rounded-4 shadow" alt="Categories" usemap="#categorieMap">
            <map name="categorieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Categories" href="categories.php">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index" style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500" data-aos-delay="500">
            <img src="uploads/Galerie/galerie.jpg" class="card-img rounded-4 shadow" alt="Galerie" usemap="#galerieMap">
            <map name="galerieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Galerie" href="image.php">
            </map>
        </div>
        <div class="mb-5 img-map img-index rounded-4" style="height: 300px; overflow: hidden;" data-aos="flip-up" data-aos-duration="1500" data-aos-delay="500">
            <div class="card-img-top card-img shadow">
                <?php
                    $carousel = new App\classes\Carousel;
                    $carousel->Read($a, 2);
                ?>
            </div>
            <?php foreach ($a as $item) { ?>
                <map name="map<?= $item['id']; ?>">
                    <area shape="rect" coords="400,0,800,400" href="<?= BASE_URL ?>produits.php?id=<?= $item['id']; ?>">
                </map>
            <?php } ?>
        </div>
    </div>    
</div>                             