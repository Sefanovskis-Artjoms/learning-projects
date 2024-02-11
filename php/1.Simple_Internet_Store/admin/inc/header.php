<?php 
  ob_start(); 
  session_start();
  include '../inc/db.php';
  include '../inc/functions.php';
  if(!isset($_SESSION['user_role']) or $_SESSION['user_role'] != 'admin'){
    header("Location: ../home.php");
  }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Icons -->
  <script
      src="https://kit.fontawesome.com/7cac6f5ac1.js"
      crossorigin="anonymous">
  </script>
  <!-- Google fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap"
    rel="stylesheet"
  />
  <!-- Summernote (editor) -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
  <!-- Style -->
  <link rel="stylesheet" href="style/general.css">
  <link rel="stylesheet" href="style/admin-header.css">
  <script defer src="js/script.js"></script>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <link rel="icon" href="../img/icons/Logo-Web.png">
  <title>TGL - Admin</title>
</head>
<body>
<!----------------->
<!-- Header -->
<!----------------->
<header class="admin-header">
  <h1 >The Glow Light Admin Panel</h1>
</header>
<!----------------->
<!-- Navigation -->
<!----------------->
<div class="page">
  <nav class="admin-main-nav">
    <ul class="admin-main-nav-list">
      <li><a class="admin-main-nav-link" href="index.php">Dashboard</a></li>
      <li><a class="admin-main-nav-link" href="admin-services.php">Services</a></a></li>
      <li><a class="admin-main-nav-link" href="admin_orders.php">Orders</a></a></li>
      <li><a class="admin-main-nav-link" href="admin_comments.php">Comments</a></a></li>
      <li><a class="admin-main-nav-link" href="admin-users.php">Users</a></a></li>
      <li><a class="admin-main-nav-link" href="../home.php">Go Back To Home</a></li>
    </ul>
  </nav>