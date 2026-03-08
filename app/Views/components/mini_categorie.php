<div class="rounded shadow text-center">
  <img src="<?= BASE_URL . $categorie['image']; ?>" class="card-img-top card-img rounded" 
  alt="..." style="height: 5rem;" usemap="#map<?= $categorie['id']; ?>">
  <map name="map<?= $categorie['id']; ?>">
    <area shape="rect" coords="0,0,300,140" href="<?= BASE_URL ?>produit/liste/<?= $categorie['id']; ?>">
</map>
<p class="position-absolute"><?= $categorie['nom'] ?></p>

</div>