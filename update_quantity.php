<?php
require 'db.php';

$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

if ($id && in_array($action, ['increment', 'decrement'])) {
    // Récupère la quantité actuelle
    $stmt = $pdo->prepare("SELECT quantite FROM articles WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();

    if ($article) {
        $quantite = $article['quantite'];
        if ($action === 'increment') {
            $quantite++;
        } elseif ($action === 'decrement' && $quantite > 0) {
            $quantite--;
        }

        // Mise à jour
        $stmt = $pdo->prepare("UPDATE articles SET quantite = ? WHERE id = ?");
        $stmt->execute([$quantite, $id]);
    }
}

header('Location: index.php');
exit;
