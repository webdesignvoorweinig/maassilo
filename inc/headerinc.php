<?php 
require_once 'core/init.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Maassilo Voorraadlijsten</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="style.css">	
</head>
<body>
  <div class="wrapper">
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#"><img src="https://www.maassilo.com/templates/maassilo/images/logo/maassilo-logo-white.svg" alt="Logo Maassilo"></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Begin Tellijst</a>
              </li>
            <li class="nav-item">
            <a class="nav-link" href="postcount.php">Eind Tellijst</a>
            </li>
              <li class="nav-item">
                <a class="nav-link" href="test.php">Export CSV</a>
              </li>
              <!--<li class="nav-item">
                <a class="nav-link" href="#">View Data</a>
              </li>-->
            </ul>
          </div>
        </div>
      </nav>
    </header>