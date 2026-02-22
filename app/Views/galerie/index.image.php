<div class="container mb-5 mt-5">
    <h1 class="mb-5 shadow rounded-4 border-start border-end border-2 border-success">Galerie</h1>     
    <div class="row">
        <?php
        foreach ($images as $row => $value) {
        ?>
            <div class="col-md-2" data-aos="fade-up" data-aos-duration="1500">
                <?php require dirname(__DIR__) . '/components/image.php'; ?> </br>
            </div>
        <?php 
        }
        ?>
    </div>   
</div>                                