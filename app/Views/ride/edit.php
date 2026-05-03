<?php ob_start(); ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-secondary text-white py-3 d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="fa-solid fa-pen-to-square me-2"></i>Modifier le trajet</h4>
                <span class="badge bg-light text-dark">ID: <?= $ride['id_ride'] ?></span>
            </div>
            <div class="card-body p-4">
                <form action="/ride/update/<?= $ride['id_ride'] ?>" method="POST">
                    
                    <div class="alert alert-warning mb-4">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i><strong>Attention :</strong> Si vous réduisez le nombre de places, assurez-vous de ne pas dépasser le nombre de places déjà réservées.
                    </div>

                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Détails du trajet</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="id_departure_agency" class="form-label fw-bold">Agence de départ</label>
                            <select class="form-select" id="id_departure_agency" name="id_departure_agency" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach ($agencies as $agency): ?>
                                    <option value="<?= $agency['id_agency'] ?>" <?= $agency['id_agency'] == $ride['id_departure_agency'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($agency['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_arrival_agency" class="form-label fw-bold">Agence d'arrivée</label>
                            <select class="form-select" id="id_arrival_agency" name="id_arrival_agency" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach ($agencies as $agency): ?>
                                    <option value="<?= $agency['id_agency'] ?>" <?= $agency['id_agency'] == $ride['id_arrival_agency'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($agency['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="departure_time" class="form-label fw-bold">Date et heure de départ</label>
                            <!-- Format de la date pour le datetime-local : YYYY-MM-DDThh:mm -->
                            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($ride['departure_time'])) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_time" class="form-label fw-bold">Date et heure d'arrivée</label>
                            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($ride['arrival_time'])) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="total_seats" class="form-label fw-bold">Nombre total de places</label>
                            <input type="number" class="form-control" id="total_seats" name="total_seats" min="1" max="9" 
                                   value="<?= $ride['total_seats'] ?>" required>
                            <small class="text-muted d-block mt-1">Actuellement : <?= $ride['available_seats'] ?> place(s) libre(s)</small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-outline-secondary">Annuler</a>
                        <button type="submit" class="btn btn-primary fw-bold"><i class="fa-solid fa-save me-2"></i>Enregistrer les modifications</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layouts/main.php'; 
?>
