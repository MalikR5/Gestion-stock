<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $quantite = intval($_POST['quantite']);

    if (!empty($nom) && $quantite >= 0) {
        $stmt = $pdo->prepare("INSERT INTO articles (nom, quantite) VALUES (?, ?)");
        $stmt->execute([$nom, $quantite]);
        header('Location: index.php');
        exit;
    } else {
        $erreur = "Remplis tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ajouter un article</h1>

    <?php if (!empty($erreur)): ?>
        <p style="color:red"><?= $erreur ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom de l'article :
            <input type="text" name="nom" required>
        </label><br>

        <label>Quantité :
            <input type="number" name="quantite" min="0" required>
        </label><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <p><a href="index.php">← Retour</a></p>
</body>
</html>
