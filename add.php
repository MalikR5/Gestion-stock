<?php
require 'db.php';

$erreur = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $quantite = intval($_POST['quantite']);

    if (!empty($nom) && $quantite >= 0) {
        $stmt = $pdo->prepare("INSERT INTO articles (nom, quantite) VALUES (?, ?)");
        $stmt->execute([$nom, $quantite]);
        header('Location: index.php');
        exit;
    } else {
        $erreur = "⚠️ Remplis tous les champs correctement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un article</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>📦 Gestion du Stock</h1>
                <p class="subtitle">Ajouter un nouvel article</p>
            </div>
        </header>

        <section class="card">
            <h2>➕ Nouvel Article</h2>

            <?php if ($erreur): ?>
                <div class="alert alert-error">
                    <?= $erreur ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="nom">📦 Nom de l'article</label>
                    <input type="text" name="nom" id="nom" placeholder="Ex: Clavier USB, Souris sans fil..." required autofocus>
                </div>

                <div class="form-group">
                    <label for="quantite">📊 Quantité initiale</label>
                    <input type="number" name="quantite" id="quantite" min="0" placeholder="0" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">✅ Ajouter l'article</button>
                    <a href="index.php" class="btn btn-secondary">← Retour</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
