<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.3/dist/flatly/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>asset/style.css">
</head>

<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(45deg,#5d87b8,#4a6fa5);">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= BASE_URL ?>home/index">Inventori</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="<?=BASE_URL ?>home/index">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>artikel/about">Tentang</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>artikel/kontak">Kontak</a></li>
                        <?php if (isset($_SESSION['is_login'])): ?>
                            <li class="nav-item"><a class="nav-link" href="<?=BASE_URL ?>artikel/home">Data Artikel</a></li>
                        <?php endif; ?>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION['is_login'])): ?>
                            <li class="nav-item"><a class="nav-link" href="<?=BASE_URL ?>user/profile">Profil</a></li>
                            <li class="nav-item"><a class="nav-link" href="<?=BASE_URL ?>user/logout">Logout (<?=$_SESSION['nama'] ?? '' ?>)</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link" href="<?=BASE_URL ?>user/login">Login</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header> 

    <div class="container my-5 flex-grow-1">