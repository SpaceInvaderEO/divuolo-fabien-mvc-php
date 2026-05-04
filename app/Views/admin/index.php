<?php 
$title = "Dashboard Administrateur";
ob_start(); 
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="display-5 text-primary fw-bold"><i class="fa-solid fa-gauge-high me-2"></i> Dashboard Admin</h1>
        <p class="lead text-muted">Bienvenue dans l'espace de gestion de l'application.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Stats Utilisateurs -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-users fs-3"></i>
                </div>
                <h3 class="fw-bold"><?= $usersCount ?></h3>
                <p class="text-muted mb-3">Utilisateurs inscrits</p>
                <a href="/admin/users" class="btn btn-outline-primary btn-sm rounded-pill">Gérer les utilisateurs</a>
            </div>
        </div>
    </div>

    <!-- Stats Agences -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-building fs-3"></i>
                </div>
                <h3 class="fw-bold"><?= $agenciesCount ?></h3>
                <p class="text-muted mb-3">Agences / Villes</p>
                <a href="/admin/agencies" class="btn btn-outline-success btn-sm rounded-pill">Gérer les agences</a>
            </div>
        </div>
    </div>

    <!-- Stats Trajets -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center p-4">
                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-car fs-3"></i>
                </div>
                <h3 class="fw-bold"><?= $ridesCount ?></h3>
                <p class="text-muted mb-3">Trajets au total</p>
                <a href="/admin/rides" class="btn btn-outline-warning btn-sm rounded-pill">Modérer les trajets</a>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fa-solid fa-circle-info me-2 text-primary"></i> Raccourcis rapides</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <a href="/admin/agencies/create" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-plus-circle me-2 text-success"></i> Ajouter une nouvelle agence</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                    <a href="/" class="list-group-item list-group-item-action py-3 d-flex justify-content-between align-items-center">
                        <span><i class="fa-solid fa-eye me-2 text-info"></i> Voir le site public</span>
                        <i class="fa-solid fa-chevron-right text-muted small"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layouts/main.php'; 
?>
