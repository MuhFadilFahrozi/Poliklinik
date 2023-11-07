<?php


if (!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
  }
?>
<form class="form row" method="POST" action="" name="pasienform" onsubmit="return(validate());">
<?php
$nama = '';
$alamat = '';
$no_hp = '';
if (isset($_GET['id'])) {
    $ambil = mysqli_query($mysqli, "SELECT * FROM pasien 
    WHERE id='" . $_GET['id'] . "'");
    while ($row = mysqli_fetch_array($ambil)) {
        $nama = $row['nama'];
        $alamat = $row['alamat'];
        $no_hp = $row['no_hp'];
    }
?>
    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
<?php
}
?>
<div class="mb-2">
        <label for="nama" class="form-label">Nama</label>
        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pasien" value="<?php echo $nama ?>">
    </div>
    <div class="mb-2">
        <label for="alamat" class="form-label">Alamat</label>
        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Pasien" value="<?php echo $alamat ?>">
    </div>
    <div class="mb-2">
        <label for="no_hp" class="form-label">No HP</label>
        <input type="text" class="form-control" name="no_hp" id="no_hp" placeholder="No HP Pasien" value="<?php echo $no_hp ?>">
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
            <th scope="col">Name</th>
            <th scope="col">Alamat</th>
            <th scope="col">No_hp</th>
            <th scope="col">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = mysqli_query($mysqli, "SELECT * FROM pasien");
        $no = 1;
        while ($data = mysqli_fetch_array($result)) :
        ?>
        <tr>
        <th scope="col"><?= $no++ ?></th>
        <td><?= $data['nama']?></td>
        <td><?= $data['alamat']?></td>
        <td><?= $data['no_hp']?></td>
        <td>
            <a class="btn btn-success rounded-pill px-3"
            href="index.php?page=pasien&id=<?= $data['id'] ?>">Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" 
                href="index.php?page=pasien&id=<?= $data['id'] ?>&aksi=hapus">Hapus
            </a>
        </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
    <?php
    if (isset($_POST['simpan'])) {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE pasien  SET 
                                            nama = '" . $_POST['nama'] . "',
                                            alamat = '" . $_POST['alamat'] . "',
                                            no_hp = '" . $_POST['no_hp'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
        } else {
            $tambah = mysqli_query($mysqli, "INSERT INTO pasien (nama,alamat,no_hp) 
                                            VALUES ( 
                                                '" . $_POST['nama'] . "',
                                                '" . $_POST['alamat'] . "',
                                                '" . $_POST['no_hp'] . "'
                                                )");
        }

        echo "<script> 
                document.location='index.php?page=pasien';
                </script>";
    }

    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            $hapus = mysqli_query($mysqli, "DELETE FROM pasien  WHERE id = '" . $_GET['id'] . "'");
        }

        echo "<script> 
                document.location='index.php?page=pasien';
                </script>";
    }
    ?>
</table>