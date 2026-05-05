<?php
require 'db.php';

$stmt = $pdo->query("SELECT * FROM articles ORDER BY id DESC");
$articles = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion du Stock</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>📦 Gestion du Stock</h1>
                <p class="subtitle">Suivi et gestion de vos articles</p>
            </div>
        </header>

        <section class="card actions-card">
            <div class="actions-header">
                <h2>📋 Articles en Stock</h2>
                <a href="add.php" class="btn btn-primary">➕ Ajouter un article</a>
            </div>
        </section>

        <section class="card">
            <?php if (count($articles) > 0): ?>
                <div class="table-responsive">
                    <table class="stock-table">
                        <thead>
                            <tr>
                                <th>📦 Article</th>
                                <th>📊 Quantité</th>
                                <th>⚙️ Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($articles as $article): 
                                $quantityClass = $article['quantite'] <= 0 ? 'qty-critical' : ($article['quantite'] <= 5 ? 'qty-low' : 'qty-ok');
                                $quantityEmoji = $article['quantite'] <= 0 ? '🔴' : ($article['quantite'] <= 5 ? '🟡' : '🟢');
                            ?>
                            <tr>
                                <td class="article-name"><?= htmlspecialchars($article['nom']) ?></td>
                                <td>
                                    <span class="quantity-badge <?= $quantityClass ?>">
                                        <?= $quantityEmoji ?> <?= $article['quantite'] ?>
                                    </span>
                                    <div class="quantity-actions">
                                        <a href="update_quantity.php?id=<?= $article['id'] ?>&action=increment" class="btn-qty btn-plus" title="Ajouter 1">➕</a>
                                        <a href="update_quantity.php?id=<?= $article['id'] ?>&action=decrement" class="btn-qty btn-minus" title="Retirer 1">➖</a>
                                    </div>
                                </td>
                                <td class="actions-cell">
                                    <a href="edit.php?id=<?= $article['id'] ?>" class="btn btn-secondary btn-sm">✏️ Modifier</a>
                                    <a href="delete.php?id=<?= $article['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?')">🗑️ Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-icon">📭</div>
                    <h3>Aucun article en stock</h3>
                    <p>Commencez par ajouter votre premier article !</p>
                    <a href="add.php" class="btn btn-primary">➕ Ajouter un article</a>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>
</html>
