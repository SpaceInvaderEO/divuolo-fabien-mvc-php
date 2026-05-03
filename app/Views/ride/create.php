<?php ob_start(); ?>

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-primary text-white py-3">
                <h4 class="mb-0"><i class="fa-solid fa-plus-circle me-2"></i>Proposer un trajet</h4>
            </div>
            <div class="card-body p-4">
                <form action="/ride/store" method="POST">
                    
                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Informations du conducteur</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label text-muted">Nom / Prénom</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']) ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted">Téléphone</label>
                            <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($_SESSION['user']['phone']) ?>" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label text-muted">Email de contact</label>
                            <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($_SESSION['user']['email']) ?>" readonly>
                            <div class="form-text">Ces informations seront visibles par les personnes souhaitant réserver votre trajet.</div>
                        </div>
                    </div>

                    <h6 class="text-primary fw-bold mb-3 border-bottom pb-2">Détails du trajet</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="id_departure_agency" class="form-label fw-bold">Agence de départ</label>
                            <select class="form-select" id="id_departure_agency" name="id_departure_agency" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach ($agencies as $agency): ?>
                                    <option value="<?= $agency['id_agency'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="id_arrival_agency" class="form-label fw-bold">Agence d'arrivée</label>
                            <select class="form-select" id="id_arrival_agency" name="id_arrival_agency" required>
                                <option value="">Choisir une ville...</option>
                                <?php foreach ($agencies as $agency): ?>
                                    <option value="<?= $agency['id_agency'] ?>"><?= htmlspecialchars($agency['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="departure_time" class="form-label fw-bold">Date et heure de départ</label>
                            <input type="datetime-local" class="form-control" id="departure_time" name="departure_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="arrival_time" class="form-label fw-bold">Date et heure d'arrivée</label>
                            <input type="datetime-local" class="form-control" id="arrival_time" name="arrival_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="total_seats" class="form-label fw-bold">Nombre de places proposées</label>
                            <input type="number" class="form-control" id="total_seats" name="total_seats" min="1" max="9" value="3" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="/" class="btn btn-outline-secondary">Annuler</a>
                        <button type="submit" class="btn btn-success fw-bold"><i class="fa-solid fa-check me-2"></i>Publier le trajet</button>
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
