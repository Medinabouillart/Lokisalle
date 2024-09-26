<?php
session_start();
include '../includes/db.php'; // Connexion à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Sélectionner l'utilisateur par email
    $sql = "SELECT * FROM utilisateurs WHERE email = :email";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // L'utilisateur est connecté
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_role'] = $user['role']; // Enregistrer le rôle dans la session

            // Vérifier le rôle de l'utilisateur
            if ($user['role'] == 'admin') {
                // Redirection vers le tableau de bord admin
                header("Location: admin_dashboard.php");
            } else {
                // Redirection vers la page d'accueil ou le profil utilisateur
                header("Location: ../index.php");
            }
            exit();
        } else {
            echo "Identifiants incorrects";
        }
    } catch (Exception $e) {
        echo "Erreur lors de la connexion : " . $e->getMessage();  // Affiche l'erreur
    }
}
?>



