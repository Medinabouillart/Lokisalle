<?php
session_start();

// Détruire toutes les données de session
$_SESSION = array(); // Réinitialiser le tableau $_SESSION

// Si vous souhaitez également détruire le cookie de session (optionnel)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header("Location: connexion.php");
exit;
?>
<?php
session_start();
session_destroy(); // Détruire la session
header('Location: connexion.php'); // Rediriger vers la page de connexion après déconnexion
exit;
?>
