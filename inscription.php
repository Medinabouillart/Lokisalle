<?php include 'includes/header.php'; ?>

<div class="container" style="max-width: 500px; margin: 50px auto;">
    <h2>Créer un compte</h2>
    <form action="admin/traitement_inscription.php" method="post" class="form-inscription">
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="pseudo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" id="prenom" name="prenom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="genre">Genre</label>
            <select id="genre" name="genre" class="form-control" required>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
                <option value="Autre">Autre</option>
            </select>
        </div>
        <button type="submit" class="btn">Inscription</button>
    </form>
</div>

<?php include 'includes/footer.php'; ?>