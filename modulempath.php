<?php
session_start();

if (!isset($_SESSION['items'])) {
    $_SESSION['items'] = [];
}
//test kedua
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    $item = [
        'id' => count($_SESSION['items']) + 1,
        'name' => $_POST['nama_barang'],
        'category' => $_POST['kategori_barang'],
        'stock' => $_POST['stock_barang'],
        'price' => $_POST['harga_barang']
    ];
    $_SESSION['items'][] = $item;
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($_GET['action'] == 'edit') {
        foreach ($_SESSION['items'] as $key => $item) {
            if ($item['id'] == $id) {
                $edit_item = $_SESSION['items'][$key];
                break;
            }
        }
    } elseif ($_GET['action'] == 'delete') {
        foreach ($_SESSION['items'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['items'][$key]);
                $_SESSION['items'] = array_values($_SESSION['items']); 
                break;
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_item'])) {
    foreach ($_SESSION['items'] as $key => $item) {
        if ($item['id'] == $_POST['id']) {
            $_SESSION['items'][$key]['name'] = $_POST['nama_barang'];
            $_SESSION['items'][$key]['category'] = $_POST['kategori_barang'];
            $_SESSION['items'][$key]['stock'] = $_POST['stock_barang'];
            $_SESSION['items'][$key]['price'] = $_POST['harga_barang'];
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        th, td {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Tambah Barang</h2>
    <form method="POST">
        <label for="nama_barang">Nama Barang:</label><br>
        <input type="text" id="nama_barang" name="nama_barang" required><br><br>

        <label for="kategori_barang">Kategori Barang:</label><br>
        <input type="text" id="kategori_barang" name="kategori_barang" required><br><br>

        <label for="stock_barang">Stock Barang:</label><br>
        <input type="number" id="stock_barang" name="stock_barang" required><br><br>

        <label for="harga_barang">Harga Barang:</label><br>
        <input type="number" id="harga_barang" name="harga_barang" required><br><br>

        <button type="submit" name="add_item">Tambah Barang</button>
    </form>

    <h2>Daftar Barang</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stock</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($_SESSION['items'] as $item): ?>
            <tr>
                <td><?= $item['id']; ?></td>
                <td><?= $item['name']; ?></td>
                <td><?= $item['category']; ?></td>
                <td><?= $item['stock']; ?></td>
                <td><?= $item['price']; ?></td>
                <td>
                    <a href="?action=edit&id=<?= $item['id']; ?>">Edit</a>
                    <a href="?action=delete&id=<?= $item['id']; ?>">Hapus</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if (isset($edit_item)): ?>
        <h2>Edit Barang ID <?= $edit_item['id']; ?></h2>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $edit_item['id']; ?>">

            <label for="nama_barang">Nama Barang:</label><br>
            <input type="text" id="nama_barang" name="nama_barang" value="<?= $edit_item['name']; ?>" required><br><br>

            <label for="kategori_barang">Kategori Barang:</label><br>
            <input type="text" id="kategori_barang" name="kategori_barang" value="<?= $edit_item['category']; ?>" required><br><br>


            <label for="stock_barang">Stock Barang:</label><br>
            <input type="number" id="stock_barang" name="stock_barang" value="<?= $edit_item['stock']; ?>" required><br><br>

            <label for="harga_barang">Harga Barang:</label><br>
            <input type="number" id="harga_barang" name="harga_barang" value="<?= $edit_item['price']; ?>" required><br><br>

            <button type="submit" name="edit_item">Simpan Perubahan</button>
        </form>
    <?php endif; ?>
</body>
</html>