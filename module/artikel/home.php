<?php
require_once __DIR__ . '/../../class/db.php'; // path ke class/db.php
$db = new Database();

$q = ''; // untukny pencarian
if (isset($_GET['submit']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    $sql_where = "nama LIKE '{$q}%'"; 
} else{ $sql_where=null;}

$b = $db->getAll('data_barang', $sql_where);
$barang = $b['data'];
$num_page = $b['num_page'];
?>
 
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Data Barang</h1>
        <a href="<?= BASE_URL ?>artikel/tambah" class="btn btn-primary">
            + Tambah Barang
        </a>
    </div>

    <form action="" method="GET" class="mb-4">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari nama barang...">
        <button type="submit" name="submit" class="btn btn-primary">Cari</button>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th width="100">Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th width="150">Aksi</th>
                </tr>
            </thead>
            <tbody> 
                <?php if ($barang && $barang->num_rows > 0): ?>
                    <?php while ($b = $barang->fetch_assoc()): ?>
                        <tr>
                            <td class="text-center">
                                <?php if ($b['gambar'] && file_exists(ROOT . 'gambar/' . basename($b['gambar']))): ?>
                                    <img src="<?= BASE_URL ?>gambar/<?= basename($b['gambar']) ?>" 
                                         width="80" class="img-thumbnail">
                                <?php else: ?>
                                    <img src="<?= BASE_URL ?>gambar/no-image.png" width="80" class="img-thumbnail">
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($b['nama']) ?></td>
                            <td><?= htmlspecialchars($b['kategori']) ?></td>
                            <td>Rp <?= number_format($b['harga_jual']) ?></td>
                            <td>Rp <?= number_format($b['harga_beli']) ?></td>
                            <td class="text-center"><?= $b['stok'] ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>artikel/ubah?id=<?= $b['id_barang'] ?>" 
                                   class="btn btn-sm btn-warning">Ubah</a>
                                <a href="<?= BASE_URL ?>artikel/hapus?id=<?= $b['id_barang'] ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Yakin hapus <?= htmlspecialchars($b['nama']) ?>?')">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            Belum ada data barang. <a href="<?= BASE_URL ?>artikel/tambah">Tambah sekarang</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <ul class="pagination">
        <?php 
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $que = !empty($q) ? "&q=$q&submit=1" : "";

        if ($page > 1) {
            $prev = $page - 1;
            $prev_link = "?page={$prev}" . (!empty($q) ? "&q={$q}" : "");
            echo "<li><a href='{$prev_link}'>&laquo; </a></li>";
        } else {
            echo "<li class='disabled'><a>&laquo; </a></li>";
        }
        

        for ($i=1; $i <= $num_page; $i++) { 
            $link = "?page={$i}";
            if (!empty($q)) $link .= "&q={$q}";
            $class = ($page == $i ? 'active' : '');
            echo "<li><a class=\"{$class}\" href=\"{$link}\">{$i}</a></li>";
        }
        
        if ($page < $num_page) {
            $next = $page + 1;
            $next_link = "?page={$next}" . (!empty($q) ? "&q={$q}" : "");
            echo "<li><a href='{$next_link}'> &raquo;</a></li>";
        } else {
            echo "<li class='disabled'><a> &raquo;</a></li>";
        }
        ?>
        </ul>
    </div>
</div>