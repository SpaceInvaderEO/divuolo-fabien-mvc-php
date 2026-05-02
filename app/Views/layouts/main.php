<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Application de Covoiturage' ?></title>
    <!-- Fichier CSS compilé à partir de SASS -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- Intégration de FontAwesome pour les icônes (optionnel) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Header -->
    <?php require_once __DIR__ . '/../partials/header.php'; ?>

    <!-- Contenu Principal -->
    <main class="container my-5 flex-grow-1">
        <!-- Emplacement pour les messages flash -->
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?= $_SESSION['flash_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['flash_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php 
                unset($_SESSION['flash_message']);
                unset($_SESSION['flash_type']);
            ?>
        <?php endif; ?>

        <!-- Contenu de la vue -->
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <?php require_once __DIR__ . '/../partials/footer.php'; ?>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/js/main.js"></script>
</body>
</html>
