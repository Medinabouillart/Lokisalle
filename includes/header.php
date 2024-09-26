<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Démarrer la session uniquement si elle n'est pas déjà active
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lokisalle</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Ton propre fichier CSS -->
    <link rel="stylesheet" href="/lokisalle/css/style.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
        <div class="container">
            <a class="navbar-brand font-weight-bold" href="/lokisalle/index.php">Lokisalle</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/lokisalle/index.php">Accueil</a>
                    </li>

                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/lokisalle/admin/admin_dashboard.php">Mon Tableau de bord</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/lokisalle/salles.php">Salles</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/lokisalle/contact.php">Contact</a>
                        </li>
                    <?php endif; ?>

                    <!-- Vérifier si l'utilisateur est connecté -->
                    <?php if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/lokisalle/profil.php">Mon Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-dark ml-2" href="/lokisalle/deconnexion.php">Déconnexion</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-dark ml-2" href="/lokisalle/connexion.php">Se connecter</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Optionnel : Ajouter un script JS pour activer Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
