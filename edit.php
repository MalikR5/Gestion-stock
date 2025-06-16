<?php
require 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: index.php');
    exit;
}

// On récupère l'article
$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->execute([$id]);
$article = $stmt->fetch();

if (!$article) {
    die("Article introuvable !");
}

// Si on a envoyé le formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $quantite = intval($_POST['quantite']);

    if (!empty($nom) && $quantite >= 0) {
        $stmt = $pdo->prepare("UPDATE articles SET nom = ?, quantite = ? WHERE id = ?");
        $stmt->execute([$nom, $quantite, $id]);
        header('Location: index.php');
        exit;
    } else {
        $erreur = "Champs invalides.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier l'article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Modifier un article</h1>

    <?php if (!empty($erreur)): ?>
        <p style="color:red"><?= $erreur ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Nom :
            <input type="text" name="nom" value="<?= htmlspecialchars($article['nom']) ?>" required>
        </label><br>

        <label>Quantité :
            <input type="number" name="quantite" min="0" value="<?= $article['quantite'] ?>" required>
        </label><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <p><a href="index.php">← Retour</a></p>
</body>
</html>
