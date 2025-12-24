<?php
require_once __DIR__ . '/../../class/db.php';
require_once __DIR__ . '/../../class/form.php';
$db = new Database();

$id = $_GET['id'] ?? 0;
$data = $db->get('data_barang', "id_barang = '$id'");
if (!$data) {
    die("Data tidak ditemukan!");
}

if ($_POST) {
    $update = [
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
            // Hapus gambar lama
            if ($data['gambar'] && file_exists(ROOT . $data['gambar'])) {
                unlink(ROOT . $data['gambar']);
            }
            $update['gambar'] = 'gambar/' . $filename;
        }
    }

    $db->update('data_barang', $update, "id_barang = '$id'");
    header("Location: " . BASE_URL . "artikel/home");
    exit;
}
?>

<div class="container my-5">
    <h2>Ubah Data Barang</h2>
    <?php
    $form = new Form("", "Update Barang"); // aiueo
    $form->addField("id", "", "hidden", $id);
    $form->addField("nama", "Nama Barang", "text", $data['nama']);
    $form->addField("kategori", "Kategori", "select", $data['kategori'], [
        "Komputer" => "Komputer",
        "Elektronik" => "Elektronik",
        "Hand Phone" => "Hand Phone"
    ]);
    $form->addField("harga_jual", "Harga Jual", "number", $data['harga_jual']);
    $form->addField("harga_beli", "Harga Beli", "number", $data['harga_beli']);
    $form->addField("stok", "Stok", "number", $data['stok']);
    $form->addField("file_gambar", "Ganti Gambar (kosongkan jika tidak diganti)", "file");
    $form->displayForm();
    ?>
    <a href="<?= BASE_URL ?>artikel/home" class="btn btn-secondary mt-3">Kembali</a>
</div>