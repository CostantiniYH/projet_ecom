<div class="container mb-5 mt-5" data-aos="fade-up" data-aos-duration="1500">
    <div class="row">
        <div class="col-md-4  mb-5 img-map img-index" style="height: 200px; overflow: hidden;"  data-aos="flip-right" data-aos-duration="1500">
            <img src="<?= BASE_URL ?>uploads/Produits/magasin.jpg" class="card-img rounded-4 shadow" alt="Produits" usemap="#produitMap">
            <map name="produitMap">
            <area shape="rect" coords="0, 0, 350,250" alt="Produits" href="<?= BASE_URL ?>produit/liste">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index " style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500">
            <img src="<?= BASE_URL ?>uploads/Categories/categories.jpg" class="card-img rounded-4 shadow" alt="Categories" usemap="#categorieMap">
            <map name="categorieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Categories" href="<?= BASE_URL ?>categorie/liste">
            </map>
        </div>
        <div class="col-md-4 mb-5 img-map img-index" style="height: 200px; overflow: hidden;" data-aos="flip-right" data-aos-duration="1500">
            <img src="<?= BASE_URL ?>uploads/Galerie/galerie.jpg" class="card-img rounded-4 shadow" alt="Galerie" usemap="#galerieMap">
            <map name="galerieMap">
                <area shape="rect" coords="0,0, 350,250" alt="Galerie" href="<?= BASE_URL ?>image/liste">
            </map>
        </div>
        <div class="mb-5 img-map img-index" style="height: 300px; overflow: hidden;" data-aos="flip-up" data-aos-duration="1500">
            <div class="card-img-top card-img shadow">
                <?php
                    $carousel = new App\Views\Components\Carousel();
                    $carousel->Read($a, 2);
                ?>
            </div>
            <?php foreach ($a as $item) { ?>
                <map name="map<?= $item['id']; ?>">
                    <area shape="rect" coords="400,0,800,400" href="<?= BASE_URL ?>produit/<?= $item['id']; ?>">
                </map>
            <?php } ?>
        </div>
    </div>    
</div>                             