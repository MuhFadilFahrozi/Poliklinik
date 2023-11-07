<?php

if (!isset($_SESSION['login'])){
    header("location:login.php");
    exit;
  }
  ?>
<form class="form row" method="POST" action="" name="dokterForm" onsubmit="return(validate());">
    <?php
    $tgl_periksa = '';
    $catatan = '';
    $obat = '';
    $id_pasien ='';
    $id_dokter ='';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, "SELECT * FROM periksa
            WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
            $obat = $row['obat'];
            $id_pasien =$row['id_pasien'];
            $id_dokter = $row['id_dokter'];
        }
        ?>
            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
            <?php
    }
    ?>
    <div class="form-group mb-2">
        <label for="inputPasien" class="sr-only">Pasien</label>
        <select class="form-control" name="id_pasien">
            <option hidden>Pilih Pasien</option>
            <?php
            $selected = '';
            $pasien = mysqli_query($mysqli, "SELECT * FROM pasien");
            while ($data = mysqli_fetch_array($pasien)) {
                if ($data['id'] == $id_pasien) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
            ?>
                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="form-group mb-2">
        <label for="alamat" class="sr-only">Dokter</label>
        <select class="form-control" name="id_dokter">
            <option hidden>Pilih Dokter</option>
            <?php
            $selected = '';
            $dokter = mysqli_query($mysqli, "SELECT * FROM dokter");
            while ($data = mysqli_fetch_array($dokter)) {
                if ($data['id'] == $id_dokter) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
            ?>
                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>
    <div class="mb-2">
        <label for="tgl_periksa" class="form-label">Tanggal Periksa</label>
        <input type="date" class="form-control" name="tgl_periksa" id="tgl_periksa" placeholder="Tanggal Periksa" value="<?php echo $tgl_periksa ?>">
    </div>
    <div class="mb-2">
        <label for="catatan" class="form-label">Catatan</label>
        <input type="text" class="form-control" name="catatan" id="catatan" placeholder="Catatan Periksa" value="<?php echo $catatan ?>">
    </div>
    <div class="mb-2">
        <label for="catatan" class="form-label">Obat</label>
        <input type="text" class="form-control" name="obat" id="bbat" placeholder="Obat " value="<?php echo $obat ?>">
    </div>
    <div class="d-flex justify-content-start mt-2">
        <button class="btn btn-primary rounded-pill px-3" type="submit" name="simpan">Simpan</button>
    </div>
</form>
<hr class="mt-3">
<!-- Tabel -->
<table class="table table-hover">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nama Pasien</th>
            <th scope="col">Nama Dokter</th>
            <th scope="col">Tanggal Periksa</th>
            <th scope="col">Catatan</th>
            <th scope="col">Obat</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $result = mysqli_query($mysqli, "SELECT pr.*,d.nama as 'nama_dokter', p.nama as 'nama_pasien' FROM periksa pr LEFT JOIN dokter d ON (pr.id_dokter=d.id) LEFT JOIN pasien p ON (pr.id_pasien=p.id) ORDER BY pr.tgl_periksa DESC");
        $no = 1;
        while ($data = mysqli_fetch_array($result)):
        ?>
        <tr>
            <th scope="col"><?=$no++?></th>
            <td><?=$data['nama_pasien']?></td>
            <td><?=$data['nama_dokter']?></td>
            <td><?=$data['tgl_periksa']?></td>
            <td><?=$data['catatan']?></td>
            <td><?=$data['obat']?></td>
            <td>
            <a class="btn btn-success rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>">
            Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
        </td>
        </tr>
        <?php endwhile;?>
    </tbody>
    <?php
    if (isset($_POST['simpan'])) {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE periksa SET 
                                            id_dokter = '" . $_POST['id_dokter'] . "',
                                            id_pasien = '" . $_POST['id_pasien'] . "',
                                            tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                            catatan = '" . $_POST['catatan'] . "',
                                            obat = '" . $_POST['obat'] . "'
                                            WHERE
                                            id = '" . $_POST['id'] . "'");
            } else {
                $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien,id_dokter,tgl_periksa,catatan,obat)
                                            VALUES (
                                                '" . $_POST['id_pasien'] . "',
                                                '" . $_POST['id_dokter'] . "',
                                                '" . $_POST['tgl_periksa'] . "',
                                                '" . $_POST['catatan'] . "',
                                                '" . $_POST['obat'] . "'
                                                )");
            }

        echo "<script>
                document.location='index.php?page=periksa';
                </script>";
    }

    if (isset($_GET['aksi'])) {
        if ($_GET['aksi'] == 'hapus') {
            $hapus = mysqli_query($mysqli, "DELETE FROM periksa  WHERE id = '" . $_GET['id'] . "'");
        }

        echo "<script> 
                document.location='index.php?page=dokter';
                </script>";
    }
    ?>
    
</table>