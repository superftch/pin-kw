<?php 
include_once('config.php');
session_start();

if (isset($_POST)) {
    if ($_POST['username'] && $_POST['password']) {
        $_SESSION['username'] = $_POST['username'];
        header("Location:/pin-kw/home.php");
        exit;
    }
    if (isset($_GET['action']) == 'logout') {
        session_destroy();
        header("Location:/pin-kw/index.php");
        exit;
    }
}

?>