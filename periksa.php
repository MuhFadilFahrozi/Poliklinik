<!doctype html>
<html>
    <head>
        
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    </head>
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
            $obat = $row['id'];
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
    <div class="form-group mb-2">
        <label for="Pilih Obat" class="form-label">Obat</label>
        <select name="obat[]" id="obat"  class="form-control" multiple="multiple">
            <?php
            $selected = '';
            $obat = mysqli_query($mysqli, "SELECT * FROM obat");
            while ($data = mysqli_fetch_array($obat)) {
                if ($data['id'] == $id_obat) {
                    $selected = 'selected="selected"';
                } else {
                    $selected = '';
                }
            ?>
                <option value="<?php echo $data['id'] ?>" <?php echo $selected ?>><?php echo $data['nama_obat'] ?></option>
            <?php
            }
            ?>
        </select>
    </div>
<?php 
            if(isset($_POST['simpan'])) {

                $obat=implode(",", $_POST['obat']);
                
                $koneksi->query("INSERT INTO obat(nama_obat) VALUES('$obat')");

            } 
            ?>
            <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

            <script>

                $(document).ready(function () {

                    $("#obat").select2({

                        placeholder: "Silahkan Pilih Obat"

                    });

                });

            </script>

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
            $result = mysqli_query($mysqli,
            "SELECT     pr.*,
             d.nama AS 'nama_dokter', 
             p.nama AS 'nama_pasien', 
             GROUP_CONCAT(o.nama_obat SEPARATOR ', ') AS 'obat'
         FROM periksa pr 
         LEFT JOIN dokter d ON (pr.id_dokter = d.id) 
         LEFT JOIN pasien p ON (pr.id_pasien = p.id)
         LEFT JOIN detail_periksa dp ON (pr.id = dp.id_periksa)
         LEFT JOIN obat o ON (dp.id_obat = o.id)
         GROUP BY pr.id
         ORDER BY pr.tgl_periksa DESC");
        $no = 1;
        $query = [' obat  '];
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
                <?php
                $sql_obat = mysqli_query($mysqli, "SELECT obat.nama_obat  FROM detail_periksa JOIN 
                obat ON detail_periksa.id_obat = obat.nama_obat WHERE 
                id_periksa = '$data[id]'") or die (mysqli_error($con));
                while ($data_obat = mysqli_fetch_array($sql_obat)){
                    echo $data_obat['id_obat']."<br>";
                }
                ?>
            <a class="btn btn-success rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>">
            Ubah</a>
            <a class="btn btn-danger rounded-pill px-3" 
            href="index.php?page=periksa&id=<?php echo $data['id'] ?>&aksi=hapus">Hapus</a>
            <a class="btn btn-warning rounded-pill px-3" 
            href="index.php?page=nota&id=<?php echo $data['id'] ?>&aksi=">Nota</a>
        </td>
        </tr>
        <?php endwhile;?>
    </tbody>
    <?php
    if (isset($_POST['simpan'])) {
        if (isset($_POST['id'])) {
            $ubah = mysqli_query($mysqli, "UPDATE periksa  SET 
                                            id_dokter = '" . $_POST['id_dokter'] . "',
                                            id_pasien = '" . $_POST['id_pasien'] . "',
                                            tgl_periksa = '" . $_POST['tgl_periksa'] . "',
                                            catatan = '" . $_POST['catatan'] . "',
                                            id = '" . $_POST['id'] . "'
                                            WHERE 
                                            id = '" . $_POST['id'] . "'");
            } else {
                $tambah = mysqli_query($mysqli, "INSERT INTO periksa(id_pasien,id_dokter,tgl_periksa,catatan,id)
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
</html>