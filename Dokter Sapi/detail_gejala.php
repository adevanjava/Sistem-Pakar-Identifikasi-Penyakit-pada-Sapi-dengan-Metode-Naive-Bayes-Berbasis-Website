<?php
session_start();
require 'aksi/koneksi.php';

if (!isset($_SESSION['username'])) {
    header('location:login.php');
} else {
    if ($_SESSION['level'] == "Pakar") {
        $status_user = "Pakar";
    } else {
        $status_user = "Administrator";
        header('location:dashboard.php');
    }
}

//ambil data di URL
$id = $_GET["id"];
// var_dump($id);
//query data  mhs berdasarkan id 
//siapin lemari data buat plih baju xD
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
//[0] buat ambil indeks pertama dari function query
$data = query("SELECT * FROM gejala WHERE id=$id")[0];

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
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- cssku -->
    <link rel="stylesheet" href="assets/cssku/style-main.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        td {
            border: 1px dashed #ddd !important;
            height: 100px;
            vertical-align: middle !important;
            padding-top: 39px !important;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
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
                        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
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
                                <li class="nav-item has-treeview">

                                    <a href="data_artikel.php" class="nav-link">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>
                                            Data Artikel
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_artikel.php" class="nav-link">
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
                                <li class="nav-item has-treeview menu-open">

                                    <a href="data_gejala.php" class="nav-link active">
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
                                <li class="nav-item has-treeview">

                                    <a href="data_artikel.php" class="nav-link">
                                        <i class="nav-icon fas fa-newspaper"></i>
                                        <p>
                                            Data Artikel
                                            <i class="right fas fa-angle-left"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="tambah_artikel.php" class="nav-link">
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail Gejala</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="lihat_gejala.php">Lihat Gejala</a></li>
                                <li class="breadcrumb-item active">Detail Gejala</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4">
                            <div class="card card-info">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-virus"></i>
                                        &nbsp;
                                        Gambar Gejala

                                    </h3>
                                </div>
                                <div class="card-body overflow-hidden" style="height: 420px;">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid" style="width:auto;height:300px" src="images/gejala/<?= $data["gambar"]; ?>" onerror="this.src='images/no_image.png'">
                                    </div>
                                    <!-- <h3 class="profile-username text-center">Gejala</h3>
                                    <p class="text-muted text-center">Detail</p> -->
                                    <div class="text-center mt-3">
                                        <a href="ubah_gejala.php?id=<?= $id; ?>" class=" text-center btn btn-info">
                                            <i class="fas fa-edit"></i>
                                            Ubah Data Gejala</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class=col-8>
                            <div class="card card-info ">

                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-info"></i>
                                        &nbsp;
                                        Detail Gejala

                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body  overflow-auto" style="height: 420px;">
                                    <!-- <div class="row">
                                        <div class="col-2">
                                            <ul class="list-group list-group-unbordered">
                                                <li class="list-group-item pt-3 pb-3">
                                                    <b>Kode Gejala</b>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Nama Gejala</b>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Keterangan</b>
                                                </li>

                                            </ul>
                                        </div>

                                    </div> -->
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:left; height: 290px">
                                            <table class="table justify-content-center" style="width: 100%; height: 100%;">
                                                <tr class="row">
                                                    <td class="col-md-2" style="border-left: 0px !important">Kode Gejala</td>
                                                    <td class="col-md-10 col-lg-10 col-xs-12" style="border-right: 0px !important"><?php echo $data['kode_gejala']; ?></td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col-md-2" style="border-left: 0px !important">Gejala</td>
                                                    <td class="" style="border-right: 0px !important"><?php echo $data['nama_gejala']; ?></td>
                                                </tr>
                                                <tr class="row">
                                                    <td class="col-md-2 col-lg-2 col-xs-2" style="border-left: 0px !important">Detail Gejala</td>
                                                    <td class="col-md-10 col-lg-10 col-xs-12" style="border-right: 0px !important"><?php echo $data['keterangan']; ?></td>
                                                </tr>
                                                <tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- 
                                    pke tabel -->
                                <!-- 
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <td><b>Kode Gejala</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Nama Gejala</b></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Keterangan</b></td>
                                                        <td></td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> -->
                            </div>
                        </div>

                        </di>
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
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>


</body>

</html>