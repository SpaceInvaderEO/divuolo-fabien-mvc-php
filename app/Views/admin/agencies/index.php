<?php 
$title = "Gestion des Agences";
ob_start(); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="display-6 text-primary fw-bold mb-0">Agences</h1>
        <p class="text-muted">Gérez les villes de départ et d'arrivée disponibles.</p>
    </div>
    <div>
        <a href="/admin/agencies/create" class="btn btn-success me-2">
            <i class="fa-solid fa-plus me-1"></i> Ajouter une agence
        </a>
        <a href="/admin" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3"># ID</th>
                                <th class="py-3">Nom de l'agence</th>
                                <th class="py-3 text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agencies as $agency): ?>
                                <tr>
                                    <td class="ps-4 text-muted">#<?= $agency['id_agency'] ?></td>
                                    <td><span class="fw-bold"><?= htmlspecialchars($agency['name']) ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group">
                                            <a href="/admin/agencies/edit/<?= $agency['id_agency'] ?>" class="btn btn-sm btn-outline-primary" title="Modifier">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                            <a href="/admin/agencies/delete/<?= $agency['id_agency'] ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette agence ? Cela pourrait affecter les trajets existants.');">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../../layouts/main.php'; 
?>
