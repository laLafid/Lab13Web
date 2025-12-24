<?php
require_once __DIR__ . '/../../class/db.php';
$db = new Database(); 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $db->delete('data_barang', "WHERE id_barang = '$id'");
}
header('Location: ' . BASE_URL . 'artikel/home'); // ini 
exit;
?>