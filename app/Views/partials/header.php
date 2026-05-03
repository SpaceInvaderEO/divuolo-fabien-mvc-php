<header class="p-3 bg-primary text-white shadow-sm">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            
            <!-- Nom de l'application à gauche -->
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none me-auto fs-4 fw-bold">
                <i class="fa-solid fa-car-side me-2"></i> Covoiturage Pro
            </a>

            <!-- Menu et boutons à droite -->
            <div class="text-end">
                <?php if (isset($_SESSION['user'])): ?>
                    
                    <?php if (isset($_SESSION['user']['is_admin']) && $_SESSION['user']['is_admin'] == 1): ?>
                        <!-- Menu Administrateur -->
                        <a href="/admin/users" class="btn btn-outline-light me-2">Utilisateurs</a>
                        <a href="/admin/agencies" class="btn btn-outline-light me-2">Agences</a>
                        <a href="/admin/rides" class="btn btn-outline-light me-2">Trajets</a>
                        <a href="/logout" class="btn btn-danger">Déconnexion</a>
                    <?php else: ?>
                        <!-- Menu Utilisateur Connecté -->
                        <span class="me-3 fw-semibold">Bonjour, <?= htmlspecialchars($_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']) ?></span>
                        <a href="/ride/create" class="btn btn-success me-2"><i class="fa-solid fa-plus me-1"></i> Créer un trajet</a>
                        <a href="/logout" class="btn btn-danger">Déconnexion</a>
                    <?php endif; ?>

                <?php else: ?>
                    <!-- Menu Utilisateur Non Connecté -->
                    <a href="/login" class="btn btn-light text-primary fw-bold">Connexion</a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</header>
