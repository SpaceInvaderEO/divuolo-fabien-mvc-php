<?php ob_start(); ?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm mt-5">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">Connexion</h4>
            </div>
            <div class="card-body p-4">
                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" class="form-control" id="email" name="email" required autofocus placeholder="votre.email@entreprise.com">
                    </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Votre mot de passe">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Se connecter</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                <small>Accès réservé au personnel de l'entreprise</small>
            </div>
        </div>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
require __DIR__ . '/../layouts/main.php'; 
?>
