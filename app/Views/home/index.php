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
                            <div class="d-flex gap-2 mb-2">
                                <button type="button" class="btn btn-outline-primary flex-grow-1 fw-bold" data-bs-toggle="modal" data-bs-target="#rideModal<?= $ride['id_ride'] ?>">
                                    <i class="fa-solid fa-eye me-1"></i> Voir les détails
                                </button>
                                
                                <?php if ($_SESSION['user']['id_user'] == $ride['id_user']): ?>
                                    <a href="/ride/edit/<?= $ride['id_ride'] ?>" class="btn btn-outline-secondary" title="Modifier">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <a href="/ride/delete/<?= $ride['id_ride'] ?>" class="btn btn-outline-danger" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ? Cette action est irréversible.');">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Modal Détails Trajet -->
                            <div class="modal fade" id="rideModal<?= $ride['id_ride'] ?>" tabindex="-1" aria-labelledby="rideModalLabel<?= $ride['id_ride'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="rideModalLabel<?= $ride['id_ride'] ?>"><i class="fa-solid fa-car me-2"></i> Détails du trajet</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Informations sur le conducteur</h6>
                                            <ul class="list-unstyled mb-4">
                                                <li class="mb-2"><i class="fa-solid fa-user text-muted me-2"></i> <strong>Conducteur :</strong> <?= htmlspecialchars($ride['first_name'] . ' ' . $ride['last_name']) ?></li>
                                                <li class="mb-2"><i class="fa-solid fa-phone text-muted me-2"></i> <strong>Téléphone :</strong> <a href="tel:<?= htmlspecialchars($ride['phone']) ?>"><?= htmlspecialchars($ride['phone']) ?></a></li>
                                                <li class="mb-2"><i class="fa-solid fa-envelope text-muted me-2"></i> <strong>Email :</strong> <a href="mailto:<?= htmlspecialchars($ride['email']) ?>"><?= htmlspecialchars($ride['email']) ?></a></li>
                                            </ul>
                                            
                                            <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Informations sur le trajet</h6>
                                            <ul class="list-unstyled">
                                                <li class="mb-2"><i class="fa-solid fa-chair text-muted me-2"></i> <strong>Total des places :</strong> <?= $ride['total_seats'] ?> place(s)</li>
                                                <li class="mb-2"><i class="fa-solid fa-user-check text-muted me-2"></i> <strong>Places restantes :</strong> <?= $ride['available_seats'] ?> place(s)</li>
                                            </ul>
                                        </div>
                                        <div class="modal-footer bg-light">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                            <a href="mailto:<?= htmlspecialchars($ride['email']) ?>?subject=Covoiturage%20<?= htmlspecialchars($ride['departure_agency_name']) ?>%20vers%20<?= htmlspecialchars($ride['arrival_agency_name']) ?>" class="btn btn-primary">
                                                <i class="fa-solid fa-paper-plane me-1"></i> Contacter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
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
