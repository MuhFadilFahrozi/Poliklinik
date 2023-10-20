<form class="form row" method="POST" action="" name="dokterForm" onsubmit="return(validate());">
    <?php
    $tgl_periksa = '';
    $catatan = '';
    if (isset($_GET['id'])) {
        $ambil = mysqli_query($mysqli, "SELECT * FROM periksa
            WHERE id='" . $_GET['id'] . "'");
        while ($row = mysqli_fetch_array($ambil)) {
            $tgl_periksa = $row['tgl_periksa'];
            $catatan = $row['catatan'];
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
        <input type="datetime-local" class="form-control" name="tgl_periksa" id="tgl_periksa" placeholder="Tanggal Periksa" value="<?php echo $tgl_periksa ?>">
    </div>
    <div class="mb-2">
        <label for="catatan" class="form-label">Catatan</label>
        <input type="text" class="form-control" name="catatan" id="catatan" placeholder="Catatan Periksa" value="<?php echo $catatan ?>">
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
        </tr>
    </thead>
    <tbody>
        <!-- pada fungsi di bawah terdapat select pr yang artinya me milih dari file periksa pilih semua dari data base (d)nama {dari nama dokter} begitu juga pada pasien 
        nahh kedua database tersbut diambil dengan menggunakan funsi left join dari data/ file id dokter dan pasien yang telah dihubungkan
        dengan database pariksa -->
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
        </tr>
        <?php endwhile;?>
    </tbody>
    <?php
    if (isset($_POST['simpan'])) {
            $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien,id_dokter,tgl_periksa,catatan)
                                            VALUES (
                                                '" . $_POST['id_pasien'] . "',
                                                '" . $_POST['id_dokter'] . "',
                                                '" . $_POST['tgl_periksa'] . "',
                                                '" . $_POST['catatan'] . "'
                                                )");

        echo "<script>
                document.location='index.php?page=periksa';
                </script>";
    }
    ?>
</table>