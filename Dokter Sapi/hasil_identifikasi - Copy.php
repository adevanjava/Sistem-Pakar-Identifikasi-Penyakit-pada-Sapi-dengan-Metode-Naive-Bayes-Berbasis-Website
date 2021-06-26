<?php

require 'aksi/koneksi.php';


//a. inisiasi variabel

$gejala = mysqli_query($koneksi, "SELECT * FROM gejala");

$m = mysqli_num_rows($gejala);

$penyakit = mysqli_query($koneksi, "SELECT * FROM penyakit");

$jumlah_penyakit = mysqli_num_rows($penyakit);

$n = 1;
$p = 1 / $jumlah_penyakit;

$ip = $_SERVER['REMOTE_ADDR']; //get ip address by apache - Basically $_SERVER['REMOTE_ADDR']gives the IP address from which the request was sent to the web server. Echo "Your IP Address is "
// echo $ip;
if (isset($_POST["konsultasi"])) {
    //nc
    $gejala_terpilih = $_POST["gejala_pilih"];
    // var_dump($gejala_terpilih);
    // echo "<br/>";
    // echo max($gejala_terpilih);

    //if(empty($gejala_terpilih)) {
    if ($gejala_terpilih == "") {
        echo "<script>alert('Gejala belum dipilih, silakan memilih gejala untuk mendapatkan hasil identifikasi!');</script>";
        //resresh ke page konsul ni mindahin ke konsul
        echo "<meta http-equiv=refresh content=0;url=konsultasi.php>";
    } else {

        //kosongin dulu tabel tmp
        mysqli_query($koneksi, "DELETE FROM tmp_identifikasi ");

        //itung dlu berapa gejala yg dipilih
        // $jml_gejala_terpilih = count($gejala_terpilih);

        //ambil angka doang dari string kode penyakit P00x 
        //001 = 1 LOL xD

        $query_angka_penyakit = mysqli_query($koneksi, "SELECT kode_penyakit FROM penyakit");

        while ($a_penyakit = mysqli_fetch_assoc($query_angka_penyakit)) {
            // mau ambil angkanya doang dari string ngubah P001 > 001
            $angka_penyakit[] = preg_replace("/[^0-9]/", "", $a_penyakit);
        }
        //cari nilai  max penyakit
        $max_penyakits = max($angka_penyakit);
        $max_penyakit = $max_penyakits['kode_penyakit']; // aray nya ubah ke string
        // echo $max_penyakit;
        // var_dump($max_penyakit);

        //proses loop berdasar jumlah max penyakit
        for ($i = 1; $i <= $max_penyakit; $i++) {
            $hasilnya = 1;
            //loop untuk setiap gejala terpilih
            foreach ($gejala_terpilih as $cek_gejala) {

                //balikin ke kode penyakit semula P001
                if ($i < 10) {
                    $kode_penyakit = "P00" . $i;
                } elseif ($i < 100) {
                    $kode_penyakit = "P0" . $i;
                } else {
                    $kode_penyakit = "P" . $i;
                }
                // gejala yg ada di tiap penyakit di cek di relasi
                $pilihrelasi = mysqli_query($koneksi, "SELECT * FROM relasi WHERE kode_penyakit='$kode_penyakit' and kode_gejala='$cek_gejala'");
                //nc=1 klo doi samaan relasi gejala
                $nc = mysqli_num_rows($pilihrelasi);
                // $nc = 1 klo ada nc=0 klo ga da > done
                // echo $nc;

                //  b. Menghitung nilai P(Vj) dan P(αi|Vj) = (nc+mp)/(n+m)
                $peluang = ($nc + ($m * $p)) / ($n + $m);
                $hasil = $peluang;
                // bikin hasilnya sebagai wadah perhitungan perkalian dari setiap foreachnya P(αi|Vj) x P(αi|Vj) xP(αi|Vj) sebanyak gejala yg di ceklis
                $hasilnya = $hasilnya * $hasil;


                // var_dump($peluang);
            }
            // c. Menghitung P(Vj) x P(αi|Vj)

            $nilaibayes = $hasilnya * $p;

            //balikin ke kode penyakit semula P001
            if ($i < 10) {
                $kode_penyakit = "P00" . $i;
            } elseif ($i < 100) {
                $kode_penyakit = "P0" . $i;
            } else {
                $kode_penyakit = "P" . $i;
            }
            // echo $kode_penyakit;

            //insert data ke tmp identifikasi
            mysqli_query($koneksi, "INSERT INTO tmp_identifikasi values ('','$ip','$kode_penyakit','$nilaibayes')"); //harusnya masukin kode penyakit
        }
        //comot data nilai yg paling gede
        $nilai = mysqli_query($koneksi, "SELECT nilai from `tmp_identifikasi` where ip='$ip'   
        ORDER BY `tmp_identifikasi`.`nilai`  DESC");

        $max = mysqli_fetch_assoc($nilai);
        // var_dump($max);

        $nilaimax = $max['nilai'];

        //leftjoin − returns all rows from the left table, even if there are no matches in the right table.
        $hasilident = mysqli_query($koneksi, "SELECT * from tmp_identifikasi left join penyakit on tmp_identifikasi.kode_penyakit=penyakit.kode_penyakit where nilai='$nilaimax' and ip='$ip'");
        // $cekhasil = mysqli_fetch_assoc($hasilident);
        // var_dump($cekhasil);

        // $jmlhasilident = mysqli_num_rows($hasilident);
    }


}

?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Dokter Sapi</title>
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- animate style -->
    <link rel="stylesheet" href="dist/css/animate.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- CSS main -->
    <link rel="stylesheet" href="assets/cssku/style-main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aladin&display=swap" rel="stylesheet">
    <style>
        td {
            padding-bottom: 10px;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-dark navbar-info fixed-top">
            <div class="container">
                <a href="index.php" class="navbar-brand m-0 p-0">
                    <img src="images/favicon.ico" alt="Dokter Sapi Logo" class="brand-image img-circle elevation-3" style="opacity: 1; margin-top: -1.15rem;">
                    <span class="brand-text font_logo"> Dokter Sapi</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3 " id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a class="nav-link font_navbar text-uppercase" href="index.php" for="index" id="index">Beranda</a>
                        <a class="nav-link font_navbar text-uppercase active" href="konsultasi.php">Konsultasi</a>
                        <a class="nav-link font_navbar text-uppercase" href="artikel.php" for="artikel">Artikel</a>
                        <a class="nav-link font_navbar text-uppercase" href="index.php#bantuan" for="bantuan">Bantuan</a>
                        <a class="nav-link font_navbar text-uppercase" href="index.php#tentang" for="tentang">Tentang</a>
                        <!-- <a class="nav-link font_navbar text-uppercase" href="index.php#saran" for="saran">Saran</a> -->
                        <a class="nav-link font_navbar text-uppercase" href="login.php">Masuk</a>
                    </div>
                </div>
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="margin-top: 75px !important;">

            <div class="content-header p-0">
            </div>
            <!-- tentang -->
            <div class="container" id="tentang">
                <!-- maintentang -->
                <!-- <div class="d-flex justify-content-center">
                    <h3 class="mt-4"><span class="align-self-center display2">KONSULTASI</span></h3>
                </div> -->
                <!-- <div class="d-flex justify-content-center">
                    <h5 class="mb-4"><i>Cara Melakukan Konsultasi Penyakit Sapi :</i></h5>
                </div> -->
                <div class="row">
                    <!-- bio -->
                    <div class="col-sm-12">

                        <div class="card" style="margin-top: 2rem;">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="card-header">
                                <div class="">
                                    <h2 class=""><span class="">Hasil Identifikasi Penyakit Sapi</span></h2>
                                    <h3 class="" style="font-size: 1.1rem;">Hasil Identifikasi berikut ini menunjukkan kemungkinan Penyakit yang dialami oleh Sapi Anda.</h3>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php
                                // $s_penyakit = mysqli_query($koneksi, "SELECT * FROM penyakit");

                                $no = 0;
                                while ($data_penyakit = mysqli_fetch_assoc($hasilident)) :
                                    // while ($hasil = $q_penyakit->fetch_array()) {
                                    $no++; ?>

                                    <div class="row mb-3" style="border-bottom :1px solid rgba(0,0,0,.125);">
                                        <div class="col-12 pb-3">
                                            <a href="javascript:void(0);" class="font-weight-bold" style="color: black;" data-target="#<?= $data_penyakit['kode_penyakit'] ?>" data-toggle="modal">
                                                <h2 class="pb-1 font-weight-bold" style="font-size: 1.2rem;"><?= $data_penyakit["nama_penyakit"]; ?> <span class="font-weight-normal"><i>( <?= $data_penyakit['nama_latin'] ?> )</i></span> </h2>

                                            </a>

                                            <div class="row">
                                                <div class="col-sm-12 col-md-4 text-center">
                                                    <a href="javascript:void(0);" class="" style="font-weight: normal; color: black;" data-target="#<?= $data_penyakit['kode_penyakit'] ?>" data-toggle="modal">
                                                        <img class="img img-thumbnail " style="height: 212px; width:auto; " src="images/penyakit/<?= $data_penyakit['gambar'] ?>" onerror="this.src='images/no_image.png'">
                                                    </a>
                                                </div>
                                                <div class="col-sm-12 col-md-8 text-center">
                                                    <div class="" style=" text-align: justify;">
                                                        <table>
                                                            <tr>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">Nama Penyakit</td>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp; </td>
                                                                <td style="vertical-align: top; ">&nbsp;<?= $data_penyakit["nama_penyakit"]; ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">Nama Latin</td>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp;</td>
                                                                <td class="font-weight-light" style="vertical-align: top; ">&nbsp;<i><?= $data_penyakit["nama_penyakit"]; ?></i></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">Gejala Penyakit</td>
                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp;</td>
                                                                <td>
                                                                    <?php
                                                                    $qry_gejala = mysqli_query($koneksi, "SELECT * from relasi left join gejala on relasi.kode_gejala=gejala.kode_gejala where kode_penyakit in ('$data_penyakit[kode_penyakit]')");

                                                                    $nom = 1;
                                                                    while ($data_gejala = mysqli_fetch_array($qry_gejala)) {
                                                                        echo "&nbsp;- &nbsp; " . $data_gejala['nama_gejala'] . "<br>";

                                                                        $nom++;
                                                                    } ?>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">
                                                                    <div class="text-left pt-2">
                                                                        <a href="javascript:void(0);" class="" style="font-weight: normal; color: black;" data-target="#<?= $data_penyakit['kode_penyakit'] ?>" data-toggle="modal">
                                                                            <small>
                                                                                <button class="btn btn-info"><span class="fa fa-info-circle"></span> Lihat Detail Penyakit</button>
                                                                            </small>

                                                                        </a>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modalnya -->
                                    <div class="modal fade" id="<?= $data_penyakit['kode_penyakit'] ?>" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-body p-0">
                                                    <div class="card card-info overflow-auto mb-0">
                                                        <div class="card-header">
                                                            <h3 class=""><?= $data_penyakit['nama_penyakit'] ?><span class="font-weight-light font-italic">&nbsp;( <?= $data_penyakit['nama_latin'] ?> )</span> </h3>

                                                        </div>
                                                        <div class="card-body">

                                                            <div class="text-left mb-4">
                                                                <div class="row " style="border: darkcyan; border-style: double; border-radius: 4px;">
                                                                    <div class="col-sm-12 col-lg-4 text-center p-2 ">
                                                                        <img class="img-thumbnail img-fluid m-2" style="width:auto;height:250px" src="images/penyakit/<?= $data_penyakit["gambar"]; ?>" onerror="this.src='images/no_image.png'">
                                                                        <p><small><?= $data_penyakit['nama_penyakit'] ?></small></p>

                                                                    </div>
                                                                    <div class="col-sm-12 col-lg-8 p-2 pt-3">
                                                                        <table class="ml-2">
                                                                            <tr>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">Nama Penyakit</td>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp; </td>
                                                                                <td style="vertical-align: top; "><?= $data_penyakit["nama_penyakit"]; ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">Nama Latin</td>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp;</td>
                                                                                <td class="font-weight-normal" style="vertical-align: top; "><i><?= $data_penyakit["nama_penyakit"]; ?></i></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">Gejala Penyakit</td>
                                                                                <td class="font-weight-bold" style="vertical-align: top; ">&nbsp; : &nbsp;</td>
                                                                                <td>
                                                                                    <?php
                                                                                    $qry_gejala = mysqli_query($koneksi, "SELECT * from relasi left join gejala on relasi.kode_gejala=gejala.kode_gejala where kode_penyakit in ('$data_penyakit[kode_penyakit]')");

                                                                                    $nom = 1;
                                                                                    while ($data_gejala = mysqli_fetch_array($qry_gejala)) {
                                                                                        echo " - &nbsp; " . $data_gejala['nama_gejala'] . "<br>";
                                                                                        $nom++;
                                                                                    }
                                                                                    ?>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-justify ">
                                                                <div class=" row p-2" style="border: darkcyan; border-style: double; border-radius: 4px;">
                                                                    <div class="col-sm-12">
                                                                        <p class="font-weight-bold">Penjelasan Penyakit : </p>
                                                                        <p><?= $data_penyakit["penjelasan"]; ?></p>
                                                                        <p class="font-weight-bold">Solusi Penyakit : </p>
                                                                        <p><?= $data_penyakit["solusi"]; ?></p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- card body -->
                                                        <div class="card-footer">
                                                            <button type="button" class="btn btn-info float-right" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div> <!-- modal body-->


                                            </div>
                                        </div>
                                    </div> <!-- modal -->


                                <?php
                                endwhile; ?>

                            </div><!-- /.card-body -->
                            <div class="card-footer">
                                <div class="form-group text-center mt-2  ">
                                    <a class="" href="simpan_hasil_identifikasi.php">
                                        <button type="button" class="btn btn-info"><i class="fa fa-save"></i>&nbsp; Simpan Hasil Identifikasi</button>
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>



                    </div> <!-- /.col -->








                </div> <!-- row -->
                <!-- maincarosel -->
            </div>
            <a id="back-to-top" href="#" class="btn btn-info btn-md back-to-top pull-left" role="button" data-toggle="tooltip" data-placement="top" data-original-title="" title="" style="display: none; margin-bottom: 50px;">
                <span class="fa fa-angle-up"></span>
            </a>
            <!-- <a id="back-to-top" href="#footer" class="btn btn-info btn-md back-to-bottom pull-left" role="button" data-toggle="tooltip" data-placement="top" data-original-title="" title="" style="display: none; margin-bottom: 50px;">
                <span class="fa fa-angle-up"></span>
            </a> -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer" style="margin-left: 0px;" id="footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Universitas Jenderal Soedirman
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2020 </strong> Barkah Ade Kurnia
    </footer>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!--animated css -->
    <script src="dist/js/wow.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript">
        $(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            var notifsaran = <?php echo json_encode($notifsaran); ?>;
            if (notifsaran > 0) {

                $(function() {
                    Toast.fire({
                        icon: 'success',
                        title: 'Saran telah berhasil dimasukkan, Terimakasih!'
                    })
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();

                } else {
                    $('#back-to-top').fadeOut();

                }
            });
            // scroll body to 0px on click
            $('#back-to-top').click(function() {
                $('#back-to-top').tooltip('hide');
                $('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });

            $('#back-to-top').tooltip('show');
        });
    </script>

</body>

</html>