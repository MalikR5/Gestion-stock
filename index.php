<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM articles ORDER BY id DESC");
$articles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Stock - Accueil</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Gestion du stock</h1>

    <a href="add.php" class="btn">➕ Ajouter un article</a>

    <table>
        <tr>
            <th>Nom</th>
            <th>Quantité</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= htmlspecialchars($article['nom']) ?></td>
            <td>
            <?= $article['quantite'] ?>
    <span class="action-buttons">
        <a href="update_quantity.php?id=<?= $article['id'] ?>&action=increment">➕</a>
        <a href="update_quantity.php?id=<?= $article['id'] ?>&action=decrement">➖</a>
    </span>
</td>
            <td>
                <a href="edit.php?id=<?= $article['id'] ?>">Modifier</a> |
                <a href="delete.php?id=<?= $article['id'] ?>" onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
