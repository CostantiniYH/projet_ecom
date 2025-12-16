<div class="container mt-5">

    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">Catégories</h1>    
    <div class="row gy-5 text-center">
        <?php foreach ($categories as $categorie) { ?>
            <div class="col-md-4 d-flex" data-aos="fade-up" data-aos-duration="2000">
                <?php require __DIR__ . '/components/categorie.php';?>            
            </div>
        <?php } ?>
    </div> 
</div>