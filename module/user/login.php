<?php
// Cek jika sudah login, langsung ke home
require_once __DIR__ . '/../../class/db.php';
if (isset($_SESSION['is_login'])) {
    header("Location: " . BASE_URL . "artikel/home");
    exit;
}
require_once __DIR__ . '/../../class/form.php';

$message = "";

if ($_POST) {
    $db = new Database();

    // Ambil input dan sanitasi (basic)
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = "Username dan password harus diisi!";
    } else {

        // Query cari user berdasarkan username
        $sql = "SELECT * FROM users WHERE username = '{$username}' LIMIT 1";
        $result = $db->query($sql);
        $data = $result->fetch_assoc();

        // Verifikasi password
        if ($data && password_verify($password, $data['password'])) {
            // Login Sukses: Set Session
            $_SESSION['is_login'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama'] = $data['nama'];

            // Redirect ke halaman utama
            header('Location:' . BASE_URL . '/artikel/home');
            exit;
        } else {
            $message = "Username atau password salah!";
        }
    }
}
?>
    <div class="login-container">
        <h3 class="text-center mb-4">Login User</h3>
        <?php if ($message): ?>
            <div class="alert alert-danger"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <a href="../home/index">Kembali ke Home</a>
        </div>
    </div>