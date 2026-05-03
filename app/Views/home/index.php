<?php ob_start(); ?>

<div class="row mb-4">
    <div class="col-12 text-center">
        <h1 class="display-5 text-primary fw-bold">Trajets disponibles</h1>
        <p class="lead text-muted">Trouvez votre covoiturage idéal parmi les trajets proposés par vos collègues.</p>
    </div>
</div>

<?php if (empty($rides)): ?>
    <div class="alert alert-info text-center" role="alert">
        <i class="fa-solid fa-circle-info me-2"></i> Aucun trajet n'est disponible pour le moment. Revenez plus tard !
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($rides as $ride): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <span class="fw-bold"><i class="fa-solid fa-calendar-day me-1"></i> <?= date('d/m/Y', strtotime($ride['departure_time'])) ?></span>
                        <span class="badge bg-light text-primary rounded-pill"><?= $ride['available_seats'] ?> place(s) libre(s)</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column mb-3">
                            <div class="d-flex align-items-start mb-2">
                                <div class="text-success me-3 fs-4"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <h5 class="card-title mb-0 fw-bold"><?= htmlspecialchars($ride['departure_agency_name']) ?></h5>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('H:i', strtotime($ride['departure_time'])) ?></small>
                                </div>
                            </div>
                            
                            <div class="ms-2 border-start border-2 border-primary my-1" style="height: 20px;"></div>
                            
                            <div class="d-flex align-items-start">
                                <div class="text-danger me-3 fs-4"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <h5 class="card-title mb-0 fw-bold"><?= htmlspecialchars($ride['arrival_agency_name']) ?></h5>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> <?= date('H:i', strtotime($ride['arrival_time'])) ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white border-0 pt-0 pb-3">
                        <?php if (isset($_SESSION['user'])): ?>
                            <button type="button" class="btn btn-outline-primary w-100 fw-bold">
                                <i class="fa-solid fa-eye me-1"></i> Voir les détails
                            </button>
                        <?php else: ?>
                            <a href="/login" class="btn btn-secondary w-100">Connectez-vous pour voir</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layouts/main.php'; 
?>
