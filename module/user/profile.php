<?php
require_once __DIR__ . '/../../class/db.php';
require_once __DIR__ . '/../../class/form.php';

$message = "";
$success = "";

// Logika Update Password
if ($_POST) {
    $db = new Database();

    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Query ambil data user yang login
    $sql = "SELECT * FROM users WHERE username = '{$_SESSION['username']}' LIMIT 1";
    $result = $db->query($sql);
    $data = $result->fetch_assoc();

    // Verifikasi password lama
    if (!password_verify($old_password, $data['password'])) {
        $message = "Password lama tidak sesuai!";
    } elseif ($new_password !== $confirm_password) {
        $message = "Password baru dan konfirmasi tidak cocok!";
    } elseif (strlen($new_password) < 6) {
        $message = "Password minimal 6 karakter!";
    } else {
        // Enkripsi password baru
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Update password di database
        $update_sql = "UPDATE users SET password = '{$hashed_password}' WHERE username = '{$_SESSION['username']}'";
        if ($db->query($update_sql)) {
            $success = "Password berhasil diubah!";
        } else {
            $message = "Gagal mengubah password!";
        }
    }
}
?>
<div class="profile-container">
    <h3 class="text-center mb-4">Profil User</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= $message ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Data Diri</h5>
            <p><strong>Nama:</strong> <?= $_SESSION['nama'] ?></p>
            <p><strong>Username:</strong> <?= $_SESSION['username'] ?></p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ubah Password</h5>
            <?php
            $form = new Form("", "Simpan Password Baru");
            $form->addField("old_password", "Password Lama", "password");
            $form->addField("new_password", "Password Baru", "password");
            $form->addField("confirm_password", "Konfirmasi Password Baru", "password");
            $form->displayForm();
            ?>
        </div>
    </div>

    <div class="mt-3 text-center">
        <a href="<?= BASE_URL ?>artikel/home" class="btn btn-secondary">Kembali ke Home</a>
    </div>
</div>