<?php
session_start();
require 'aksi/koneksi.php';

if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

$q_gejala = mysqli_query($koneksi, "SELECT*FROM gejala");
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dokter Sapi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- icon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- CSS main -->
    <link rel="stylesheet" href="assets/cssku/style-main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- navbar sidebar -->
        <section>
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-dark navbar-info bg-color">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#"> <?= $_SESSION['nama'] ?>&nbsp;
                            <i class="nav-icon fas fa-caret-square-down"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                            <a href="profil.php" class="dropdown-item">
                                <i class="fas fa-user mr-2"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="aksi/logout.php" class="dropdown-item">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-info elevation-3">
                <!-- Brand Logo -->
                <div class="container pl-3 bg-color image" style="border-bottom: 1px solid #17a2b8;">
                    <a href="dashboard.php" class="navbar-brand m-0 p-0">
                        <img src="images/favicon.ico" alt="Dokter Sapi Logo" class="brand-image img-circle elevation-3" style="height:36px; opacity: 1; margin-top: -1.15rem;">
                        <span class="brand-text font_sidebar" style="margin-left: 5px;"> Dokter Sapi</span>
                    </a>
                </div>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex" style="border-bottom: 1px solid #17a2b8;">
                        <div class="image" style="padding-top: 10px!important;">
                            <img src="images/pengguna/<?= $_SESSION['foto'] ?>" class="img-circle elevation-2" alt="User Image" style="width: 2.7rem;height:2.7rem ;">
                        </div>
                        <div class="info">
                            <a href="#" class=""><?= $_SESSION['nama'] ?></a>
                            <a href="#" class="d-block font-italic"><?= $_SESSION['level'] ?></a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column  nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="dashboard.php" class="nav-link">
                                    <i class="nav-icon fas fa-home"></i>
                                    <p>
                                        Beranda
                                    </p>
                                </a>
                            </li>
                            <?php if ($_SESSION['level'] == 'Administrator') : ?>
                                <!-- admin -->

                                <li class="nav-item has-treeview">
                                    <a href="data_pakar.php" class="nav-link">
                                        <i class="nav-icon fas fa-users"></i>
                                        <p>
                                            Data Pakar
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_pakar.php" class="nav-link">
                                                <i class="fas fa-plus-circle nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Tambah Data Pakar
                                                </p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="lihat_pakar.php" class="nav-link">
                                                <i class="fas fa-list-ul nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Lihat Daftar Pakar
                                                </p>

                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="nav-item has-treeview menu-open">
                                    <a href="data_artikel.php" class="nav-link active">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>
                                            Data Artikel
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview ">
                                        <li class="nav-item">
                                            <a href="tambah_artikel.php" class="nav-link active">
                                                <i class="fas fa-plus-circle nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Tambah Artikel
                                                </p>

                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="lihat_artikel.php" class="nav-link">
                                                <i class="fas fa-list-ul nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Lihat Daftar Artikel
                                                </p>

                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="lihat_saran.php" class="nav-link">
                                        <i class="nav-icon fas fa-comment-alt"></i>
                                        <p>
                                            Data Saran
                                        </p>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="bantuan_admin.php" class="nav-link">
                                        <i class="nav-icon fas fa-info-circle"></i>
                                        <p>
                                            Bantuan
                                        </p>
                                    </a>
                                </li>

                            <?php else : ?>
                                <!-- pakar -->

                                <li class="nav-item has-treeview">
                                    <a href="data_penyakit.php" class="nav-link">
                                        <i class="nav-icon fas fa-laptop-medical"></i>
                                        <p>
                                            Data Penyakit
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_penyakit.php" class="nav-link">
                                                <i class="fas fa-plus-circle nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Tambah Data Penyakit
                                                </p>

                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="lihat_penyakit.php" class="nav-link">
                                                <i class="fas fa-list-ul nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Lihat Daftar Penyakit
                                                </p>

                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview">

                                    <a href="data_gejala.php" class="nav-link">
                                        <i class="nav-icon fas fa-virus"></i>
                                        <p>
                                            Data Gejala
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_gejala.php" class="nav-link">
                                                <i class="fas fa-plus-circle nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Tambah Data Gejala
                                                </p>

                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="lihat_gejala.php" class="nav-link">
                                                <i class="fas fa-list-ul nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Lihat Daftar Gejala
                                                </p>

                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview menu-open">

                                    <a href="data_artikel.php" class="nav-link active">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>
                                            Data Artikel
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_artikel.php" class="nav-link active">
                                                <i class="fas fa-plus-circle nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Tambah Artikel
                                                </p>

                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="lihat_artikel.php" class="nav-link">
                                                <i class="fas fa-list-ul nav-icon" style="font-size: 14px;"></i>
                                                <p style="font-size: 15.5px;">
                                                    Lihat Daftar Artikel
                                                </p>

                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <!-- <li class="nav-item">
                                    <a href="lihat_saran.php" class="nav-link">
                                        <i class="nav-icon fas fa-comment-alt"></i>
                                        <p>
                                            Data Saran
                                        </p>
                                    </a>
                                </li> -->
                                <li class="nav-item">
                                    <a href="bantuan_pakar.php" class="nav-link">
                                        <i class="nav-icon fas fa-info-circle"></i>
                                        <p>
                                            Bantuan
                                        </p>
                                    </a>
                                </li>

                            <?php endif; ?>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- Main Sidebar Container -->
        </section>
        <!-- end of sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Tambah Artikel</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Tambah Artikel</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">Tambah Artikel</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form role="form" action="aksi/tambah_artikel.php" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <input type="hidden" name="nama_penulis" id="" value="<?= $_SESSION['nama'] ?>">
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-right" for="judul_artikel">Judul Artikel :</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="judul_artikel" id="judul_artikel" placeholder="Judul Artikel" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                            <label class="col-sm-3 text-right" class="col-sm-3 text-right" for="gambar"> Sampul Artikel : </label>
                                            <div class="form-group col-sm-9 mb-0">
                                                <div class="input-file">
                                                    <input type="file" name="gambar" id="fupload">
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="gambar"></label>
                                                    <div class="" id="hasil" style="display:none;">
                                                        <img class="img-fluid" style="height: 150px;" src=" #" id="tampil">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 text-right" for="isi_artikel">Isi Artikel :</label>
                                            <div class="col-sm-9">
                                                <textarea class="textarea" name="isi_artikel" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                                            </div>

                                        </div>


                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <div class="row justify-content-center">
                                                <button type="submit" name="submit" class="btn btn-info float-right">Tambah Artikel</button>
                                            </div>
                                        </div>
                                </form>
                            </div>

                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Universitas Jenderal Soedirman
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2020 </strong> Sistem Pakar Identifikasi Penyakit Sapi
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables -->

    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- page script -->
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            // Summernote
            $('.textarea').summernote()
        })
    </script>
    <!-- //view file uplod -->
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#tampil').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#fupload").change(function() {
            readURL(this);
            $('#hasil').show();
        });
    </script>
    <!-- //uplod file
    <script type="text/javascript">
        $(document).ready(function() {
            bsCustomFileInput.init();
        });
    </script> -->
</body>

</html>