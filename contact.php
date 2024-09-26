<?php include 'includes/header.php'; ?>

<main>
    <div class="container">
        <h2>Contactez-nous</h2>
        
        <p>Vous avez des questions ? N'hésitez pas à nous contacter en remplissant le formulaire ci-dessous. Nous reviendrons vers vous dès que possible.</p>
        
        <form action="contact.php" method="POST">
            <div class="form-group">
                <label for="name">Votre nom</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Votre email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="message">Votre message</label>
                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-outline-primary">Envoyer</button>
        </form>

        <?php
        // Vérification des champs du formulaire
        if (isset($_POST['submit'])) {
            $errors = [];

            // Validation du nom (lettres seulement, minimum 2 caractères)
            if (!preg_match("/^[a-zA-Z-' ]{2,}$/", $_POST['name'])) {
                $errors[] = "Le nom doit contenir uniquement des lettres et au moins 2 caractères.";
            }

            // Validation de l'email (vérification de la structure de l'email)
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors[] = "L'adresse email est invalide.";
            }

            // Validation du message (au moins 10 caractères)
            if (strlen($_POST['message']) < 10) {
                $errors[] = "Le message doit contenir au moins 10 caractères.";
            }

            // S'il y a des erreurs, les afficher
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<p style='color:red;'>$error</p>";
                }
            } else {
                // Si tout est valide, envoyer l'email
                $name = htmlspecialchars($_POST['name']);
                $email = htmlspecialchars($_POST['email']);
                $message = htmlspecialchars($_POST['message']);
                
                $to = "admin@lokisalle.com"; // L'adresse email de l'administrateur
                $subject = "Nouveau message de $name";
                $body = "Nom: $name\nEmail: $email\n\nMessage:\n$message";
                $headers = "From: $email";

                // Envoi de l'email
                if (mail($to, $subject, $body, $headers)) {
                    echo "<p>Merci ! Votre message a été envoyé avec succès.</p>";
                } else {
                    echo "<p>Erreur : Le message n'a pas pu être envoyé. Veuillez réessayer plus tard.</p>";
                }
            }
        }
        ?>
    </div>

    <!-- Section supplémentaire avec les informations de contact -->
    <section class="contact-info-section">
        <div class="container">
            <h3>Besoin d'aide ? Nous sommes là pour vous aider à trouver l'espace parfait.</h3>
            <div class="contact-info-card">
                <img src="images/contact.jpg" alt="Responsable des ventes" class="img-fluid">
                <div class="contact-details">
                    <h4>Marie Dupont</h4>
                    <p>Responsable des ventes</p>
                    <p><i class="fa fa-phone"></i> 01 23 45 67 89</p>
                    <p><i class="fa fa-envelope"></i> marie.dupont@lokisalle.com</p>
                    <p><i class="fa fa-linkedin"></i> <a href="#">LinkedIn</a></p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>