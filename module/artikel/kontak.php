<?php 
require_once __DIR__ . '/../../class/db.php'; // sesuaikan pathnya
?>

<div class="row justify-content-center text-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow">
            <div class="card-body p-5">
                <h1 class="display-5 fw-bold text-primary mb-4">Halo Halo</h1>
                <p class="lead text-muted mb-5">ini adalah halaman kontak</p>
                <a href="<?= BASE_URL ?>artikel/home.php" class="btn btn-primary btn-lg rounded-pill px-5">
                    Balik ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>