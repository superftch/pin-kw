<?php
    include_once('config.php');
    if (empty($_SESSION['username'])) {
        header("Location:/pin-kw/index.php");
        exit;
    }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Beranda</title>
    <link rel="icon" type="image/png" href="https://pin.kemdikbud.go.id/pin/asset/img/dikti.png" />

    <link href="https://pin.kemdikbud.go.id/pin//asset/css/custom2.css" rel="stylesheet">
    <link href="https://pin.kemdikbud.go.id/pin//asset/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="https://pin.kemdikbud.go.id/pin//asset/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
    <link href="https://pin.kemdikbud.go.id/pin//asset/css/plugins/ladda/ladda.min.css" rel="stylesheet">
    <link href="https://pin.kemdikbud.go.id/pin//asset/css/plugins/pace/pace.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://pin.kemdikbud.go.id/pin//asset/css/style.css" rel="stylesheet">
    <link href="https://pin.kemdikbud.go.id/pin//asset/css/plugins/iCheck/custom.css" rel="stylesheet">

    <!-- Toastr style -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link
        href="https://pin.kemdikbud.go.id/pin//asset/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css"
        rel="stylesheet">

    <script src="https://pin.kemdikbud.go.id/pin//asset/js/jquery-2.1.1.js"></script>
    <script src="https://pin.kemdikbud.go.id/pin//asset/js/inspinia.js"></script>
    <script src="https://pin.kemdikbud.go.id/pin//asset/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/d7ac5e962d.js"></script>

</head>

<body class="top-navigation">

    <script>
        $(document).ready(function () {
            $('#myModal6').modal({
                show: false
            });
            $(".sk-spinner").hide();

            $('form').submit(function () {
                $('#myModal6').modal({
                    show: true
                });
                $(".sk-spinner").show();
                var id = this.id;

                if (id == 'unduh_calon_lulusan') {
                    $('#myModal6').modal({
                        show: false
                    });
                    $(".sk-spinner").hide();
                    window.setTimeout(
                        function () {
                            location.reload(true)
                        },
                        1500
                    );
                }

                if (id == 'unduh') {
                    $('#myModal6').modal({
                        show: false
                    });
                    $(".sk-spinner").hide();
                    window.setTimeout(
                        function () {
                            location.reload(true)
                        },
                        1500
                    );
                    window.location.href = 'http://localhost/pin/index.php/preview/#finish';
                }

            })
        });
    </script>

    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-contentt">
                <div class="sk-spinner sk-spinner-wave">
                    <div class="sk-rect1"></div>
                    <div class="sk-rect2"></div>
                    <div class="sk-rect3"></div>
                    <div class="sk-rect4"></div>
                    <div class="sk-rect5"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="wrapper">
        <div id="page-wrapper" class="white-bg">
            <div class="row gray-bg">
            </div>

            <div class="row border-bottom gray-bg">
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-header">

                    </div>
                    <div class="navbar-collapse collapse" id="navbarrrr">
                        <ul class="nav navbar-nav">

                            <li>
                                <a href="#" style="font-size:170%">
                                    <i class="fa fa-plus"></i> Reservasi Nomor Ijazah
                                </a>
                            </li>
                            <li>
                                <a href="https://pin.kemdikbud.go.id/pin/index.php/home/batal" style="font-size:170%">
                                    <i class="fa fa-remove"></i> Batal
                                </a>
                            </li>
                        </ul>
                        <ul class="nav navbar-top-links navbar-right">
                            <li style="color:white;font-size:120%">
                                 <?=$_SESSION['username'] ?> (Ceritanya Admin) </li>
                            <li>
                                <a href="/pin-kw/auth.php?action=logout" style="font-size:120%">
                                    <i class="fa fa-sign-out"></i> Log out
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>