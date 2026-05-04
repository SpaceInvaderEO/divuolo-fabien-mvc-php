<?php 
$title = $title ?? "Gestion d'agence";
ob_start(); 
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-6 text-primary fw-bold mb-0"><?= $title ?></h1>
            <a href="/admin/agencies" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-1"></i> Retour
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="<?= isset($agency) ? '/admin/agencies/update/' . $agency['id_agency'] : '/admin/agencies/store' ?>" method="POST">
                    <div class="mb-4">
                        <label for="name" class="form-label fw-bold">Nom de l'agence (ville)</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($agency['name'] ?? '') ?>" placeholder="Ex: Paris, Lyon, Bordeaux..." required autofocus>
                        <div class="form-text text-muted">Ce nom apparaîtra dans les listes de départ et d'arrivée.</div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2 fw-bold">
                            <i class="fa-solid fa-save me-1"></i> <?= isset($agency) ? 'Enregistrer les modifications' : 'Créer l\'agence' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../../layouts/main.php'; 
?>
