<div class="container mt-5 mb-5">
    <form action="/<?php if (!$id) { echo 'register'; } else { echo 'moi'; } ?>" method="post" class="p-5 col-md-6 mb-5 shadow-lg
    rounded-3 border-blue mx-auto" enctype="multipart/form-data">
        <h2 class="text-center"><?= $user ? 'Modifier votre profil' : 'Inscription' ?></h2>
        <div class="form-group mb-2">
            <label for="prenom">Prénom :</label>
            <input value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" type="text"class="form-control" id="prenom" name="prenom" required>
        </div>
        <div class="form-group mb-2">
            <input type="hidden" id= "id" name="id"  value="<?= $user['id'] ?? '' ?>">
            <label for="nom">Nom :</label> 
            <input value="<?= htmlspecialchars($user['nom'] ?? '') ?>" type="text" class="form-control" id="nom" name="nom" required>
        </div>
        <div class="form-group mb-2">
            <label for="telephone">Numéro de téléphone :</label>
            <input value="<?= htmlspecialchars($user['telephone'] ?? '') ?>" type="telephone" class="form-control" id="telephone" name="telephone" required>
        </div>
        <div class="form-group mb-2">
            <label for="societe">Société :</label>
            <input value="<?= htmlspecialchars($user['societe'] ?? '') ?>" type="text" class="form-control" id="societe" name="societe" required>
        </div>
        <div class="form-groupe mb-2">
            <label for="image">Photo de profil</label>
            <input value="" type="file" class="form-control" id="image" name="image" <?php if (!$id) { echo 'required'; } ?>>
        </div>
        <div class="form-group mb-2">
            <label for="email">Email :</label>
            <input value="<?= htmlspecialchars($user['email'] ?? '') ?>" type="email" class="form-control" id="email" name="email" required>
        </div>

        <?php if (!$id) { ?>
            <div class="form-group mb-2">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group mb-3">
                <label for="password2">Confirmation mot de passe :</label>
                <input type="password" class="form-control" id="password2" name="password2" required>
            </div>
            <div class="form-group text-center">
                <input type="submit" class="col-sm-12 btn btn-success" value="S'inscrire">
            </div>
        <?php } else { ?>
            <div class="form-group text-center">
                <input type="submit" class="col-sm-12 btn btn-success" value="Modifier les informations">
            </div>
        <?php } ?>
    </form>
</div>