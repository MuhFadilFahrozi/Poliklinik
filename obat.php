<?php

if (!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
  }

?>
<form class="form row" method="POST" action="" name="obatform" onsubmit="return(validate());">

<?php
$nama_obat = '';
$kemasan = '';
$harga = '';
if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM obat 
    WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama_obat = $row['nama_obat'];
        $kemasan = $row['kemasan'];
        $harga = $row['harga'];
    }
?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<?php
}
?>
<div class="mb-2">
        <label for="nama_obat" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama_obat" id="nama_obat" placeholder="Nama Obat" value="<?php echo $nama_obat ?>">
    </div>
    <div class="mb-2">
        <label for="kemasan" class="form-label">Kemasan</label>
        <input type="text" class="form-control" name="kemasan" id="kemasan" placeholder="Kemasan Obat" value="<?php echo $kemasan ?>">
    </div>
    <div class="mb-2">
        <label for="harga" class="form-label">Harga</label>
        <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga Obat" value="<?php echo $harga ?>">
    </div>
    <div class="d-flex justify-content-start mt-2">
        <button class="btn btn-primary rounded-pill px-3" type="submit"name="simpan">Simpan</button>
    </div>
</form>
<hr class="mt-3">
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Obat</th>
            <th scope="col">Kemasan</th>
            <th scope="col">Harga</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM obat");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) :
        ?>
        <tr>
        <th scope="col"><?= $no++ ?></th>
        <td><?= $data['nama_obat']?></td>
        <td><?= $data['kemasan']?></td>
        <td><?= $data['harga']?></td>
        <td>
            <a class="btn btn-success rounded-pill px-3"
            href="index.php?page=obat&id=<?= $data['id'] ?>">Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" 
                href="index.php?page=obat&id=<?= $data['id'] ?>&aksi=hapus">Hapus
            </a>
        </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
    <?php
    if (isset($_POST['simpan'])) {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE obat  SET 
                                            nama_obat = '" . $_POST['nama_obat'] . "',
                                            kemasan = '" . $_POST['kemasan'] . "',
                                            harga = '" . $_POST['harga'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
        } else {
            $tambah = mysqli_query($mysqli, "INSERT INTO obat (nama_obat,kemasan,harga) 
                                            VALUES ( 
                                                '" . $_POST['nama_obat'] . "',
                                                '" . $_POST['kemasan'] . "',
                                                '" . $_POST['harga'] . "'
                                                )");
        }

        echo "<script> 
                document.location='index.php?page=obat';
                </script>";
    }

    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            $hapus = mysqli_query($mysqli, "DELETE FROM obat  WHERE id = '" . $_GET['id'] . "'");
        }

        echo "<script> 
                document.location='index.php?page=obat';
                </script>";
    }
    ?>
</table>