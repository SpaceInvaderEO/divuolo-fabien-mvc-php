<?php 
$title = "Modération des Trajets";
ob_start(); 
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="display-6 text-primary fw-bold mb-0">Tous les trajets</h1>
        <p class="text-muted">Consultez et gérez l'ensemble des trajets publiés.</p>
    </div>
    <a href="/admin" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Retour
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">Conducteur</th>
                        <th class="py-3">Départ</th>
                        <th class="py-3">Arrivée</th>
                        <th class="py-3">Places</th>
                        <th class="py-3 text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rides)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Aucun trajet trouvé.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rides as $ride): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold"><?= htmlspecialchars($ride['first_name'] . ' ' . $ride['last_name']) ?></span>
                                </td>
                                <td>
                                    <div class="small fw-bold text-success"><?= htmlspecialchars($ride['departure_agency_name']) ?></div>
                                    <div class="text-muted smaller"><?= date('d/m/Y H:i', strtotime($ride['departure_time'])) ?></div>
                                </td>
                                <td>
                                    <div class="small fw-bold text-danger"><?= htmlspecialchars($ride['arrival_agency_name']) ?></div>
                                    <div class="text-muted smaller"><?= date('d/m/Y H:i', strtotime($ride['arrival_time'])) ?></div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-primary border"><?= $ride['available_seats'] ?> / <?= $ride['total_seats'] ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="/admin/rides/delete/<?= $ride['id_ride'] ?>" class="btn btn-sm btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet en tant qu\'administrateur ?');">
                                        <i class="fa-solid fa-trash-can me-1"></i> Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layouts/main.php'; 
?>
