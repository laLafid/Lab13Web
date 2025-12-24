<?php
require_once __DIR__ . '/../../class/db.php';
require_once __DIR__ . '/../../class/form.php';
$db = new Database();

if ($_POST) {
    $data = [
        'nama'       => $_POST['nama'],
        'kategori'   => $_POST['kategori'],
        'harga_jual' => $_POST['harga_jual'],
        'harga_beli' => $_POST['harga_beli'],
        'stok'       => $_POST['stok'],
    ];

    if (!empty($_FILES['file_gambar']['name']) && $_FILES['file_gambar']['error'] === 0) {
        $ext = pathinfo($_FILES['file_gambar']['name'], PATHINFO_EXTENSION);
        $filename = time() . '_' . rand(1000,9999) . '.' . $ext;
        $destination = ROOT . 'gambar/' . $filename;
        if (move_uploaded_file($_FILES['file_gambar']['tmp_name'], $destination)) {
            $data['gambar'] = 'gambar/' . $filename;
        }
    }

    $db->insert('data_barang', $data);
    header("Location: " . BASE_URL . "artikel/home");
    exit;
}
?>

<div class="container my-5">
    <h2>Tambah Barang Baru</h2>
    <?php
    $form = new Form("", "Simpan Barang"); // ganti baru e
    $form->addField("nama", "Nama Barang", "text");
    $form->addField("kategori", "Kategori", "select", '', [
        "Komputer" => "Komputer",
        "Elektronik" => "Elektronik",
        "HandPhone" => "HandPhone",
        "Tablet" => "Tablet",
        "Aksesoris" => "Aksesoris"
    ]);
    $form->addField("harga_jual", "Harga Jual", "number");
    $form->addField("harga_beli", "Harga Beli", "number");
    $form->addField("stok", "Stok", "number");
    $form->addField("file_gambar", "Gambar Barang", "file");  
    $form->displayForm();
    ?>
    <a href="<?= BASE_URL ?>artikel/home" class="btn btn-secondary mt-3">Kembali</a>
</div>