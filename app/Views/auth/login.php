<div class="container">
    <div class="row gap-3 d-flex">
        <section class="p-5 col-md-6 mx-auto shadow-lg rounded-4 border-blue">

            <form action="<?= BASE_URL ?>auth/login" method="post" >
                <h2 class="text-center mb-4">Connexion</h2>
                <div class="form-group mb-2">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group mb-2">
                    <label for="password">Mot de passe :</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <a href="" class="mt-5">Mot de passe oublié ?</a>
                <div class="mt-4 col-md-4 mx-auto">
                    <input type="submit" name="login" class="btn btn-primary w-100" value="Se connecter">
                </div>
            </form>
        </section>
        
        <section class="p-5 col-md-3 shadow-lg rounded-4 border-blue hvr-grow">
            <p>Vous n'avez pas encore de compte :</p>
            <a href="<?= BASE_URL ?>auth/register" class="stretched-link">inscrivez-vous</a>
        </section>

    </div>
</div>

