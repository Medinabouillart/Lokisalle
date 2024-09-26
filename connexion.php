<?php include 'includes/header.php'; ?>

<div class="container" style="max-width: 500px; margin: 50px auto;">

<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="connexion.php">Connexion</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="inscription.php" style="color: black">Créer un compte</a>
        </li>
    </ul>

    <h2>Bienvenue</h2>
    <p>Connectez-vous à l'aide de votre adresse E-mail et de votre mot de passe.</p>
    <form action="admin/gestion_connexion.php" method="post">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="mot_de_passe" class="form-control">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="remember" name="remember">
            <label class="form-check-label" for="remember">Se souvenir de moi</label>
        </div>

        <!-- Bouton de connexion -->
        <button type="submit" class="btn w-100">Connexion</button>
        
        <!-- Lien "Mot de passe oublié ?" juste après le bouton -->
        <div class="text-center mt-2">
            <a href="#" class="forgot-password text-black" style="color: black">Mot de passe oublié ?</a>
        </div>
    </form>
</div>

</div>

<?php include 'includes/footer.php'; ?>



