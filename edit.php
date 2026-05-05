<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$erreur = null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// On récupère l'article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die("❌ Article introuvable !");
}

// Si on a envoyé le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $quantite = intval($_POST['quantite']);

    if (!empty($nom) && $quantite >= 0) {
        $stmt = $pdo->prepare("UPDATE articles SET nom = ?, quantite = ? WHERE id = ?");
        $stmt->execute([$nom, $quantite, $id]);
        header('Location: index.php');
        exit;
    } else {
        $erreur = "⚠️ Champs invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>📦 Gestion du Stock</h1>
                <p class="subtitle">Modifier un article</p>
            </div>
        </header>

        <section class="card">
            <h2>✏️ Modifier "<?= htmlspecialchars($article['nom']) ?>"</h2>

            <?php if ($erreur): ?>
                <div class="alert alert-error">
                    <?= $erreur ?>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="nom">📦 Nom de l'article</label>
                    <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($article['nom']) ?>" required autofocus>
                </div>

                <div class="form-group">
                    <label for="quantite">📊 Quantité</label>
                    <input type="number" name="quantite" id="quantite" min="0" value="<?= $article['quantite'] ?>" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
                    <a href="index.php" class="btn btn-secondary">← Retour</a>
                </div>
            </form>
        </section>
    </div>
</body>
</html>
