<?php
  session_start();
  require_once "pdo.php";
  require_once "utility_functions.php";
  isLoggedIn();

  if(isset($_POST["add"]))
  {
    if(isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["year"]))
    {
      if((strlen($_POST["make"]) < 1) || (strlen($_POST["model"]) < 1) || (strlen($_POST["year"]) < 1))
      {
        $_SESSION["error"] = "Ne visi laukai buvo užpildyti.";
        header("Location: forms.php");
        return;
      }
      if($_POST['body'] == 0 || $_POST['fuel'] == 0 || $_POST['gearbox'] == 0)
      {
        $_SESSION["error"] = "Būtina pasirinkti visus aktyvius laukus.";
        header("Location: forms.php");
        return;
      }
      if(!is_numeric($_POST["year"]))
      {
        $_SESSION["error"] = "Metai - turi būti sveikasis skaičius.";
        header("Location: forms.php");
        return;
      }

      $stmt = $pdo->prepare('INSERT INTO autos (user_id, brand, model, year, body_id, fuel_id, gearbox_id) VALUES ( :uid, :br, :md, :yr, :bid, :fid, :gid)');
      $stmt->execute(array(
        ':uid' => $_SESSION['uid'],
        ':br' => $_POST['make'],
        ':md' => $_POST['model'],
        ':yr' => $_POST['year'],
        ':bid' => $_POST['body'],
        ':fid' => $_POST['fuel'],
        ':gid' => $_POST['gearbox']));
      $_SESSION["success"] = "Automobilis pridėtas";
      header("Location: forms.php");
      return;

    }
  }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Genius solutions - Naujo automobilio pridėjimas</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet"/>
  <script src="assets/js/pace.min.js"></script>
  <!--favicon-->
  <link rel="icon" href="assets/images/faviconn.ico" type="image/x-icon">
  <!-- simplebar CSS-->
  <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Sidebar CSS-->
  <link href="assets/css/sidebar-menu.css" rel="stylesheet"/>
  <!-- Custom Style-->
  <link href="assets/css/app-style.css" rel="stylesheet"/>
  <!-- Mano Stiliai-->
  <link href="assets/css/my-style.css" rel="stylesheet"/>
  <!-- Scripts-->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <!-- Mano Scriptai-->
  <script src="assets/js/manoscriptai.js"></script>
</head>

<body class="bg-theme bg-theme4">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

 <!--Start sidebar-wrapper-->
   <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
     <div class="brand-logo">
      <a href="index.php">
       <img src="assets/images/logo.png" class="logo-icon" alt="logo icon">
       <h5 class="logo-text">Genius solutions</h5>
     </a>
   </div>
   <ul class="sidebar-menu do-nicescrol">
     <li class="sidebar-header">MENIU</li>
     <li>
       <a href="index.php">
         <i class="zmdi zmdi-view-dashboard"></i> <span>Pagrindinis</span>
       </a>
     </li>

     <li>
       <a href="forms.php">
         <i class="zmdi zmdi-format-list-bulleted"></i> <span>Pridėti automobilį</span>
       </a>
     </li>
    </ul>

   </div>
   <!--End sidebar-wrapper-->


<!--Start topbar header-->
<header class="topbar-nav">
 <nav class="navbar navbar-expand fixed-top">
  <ul class="navbar-nav mr-auto align-items-center">
    <li class="nav-item">
      <a class="nav-link toggle-menu" href="javascript:void();">
       <i class="icon-menu menu-icon"></i>
     </a>
    </li>
  </ul>

  <ul class="navbar-nav align-items-center right-nav-link">
    <li class="nav-item">
      <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
        <span class="user-profile"><img src="https://via.placeholder.com/110x110" class="img-circle" alt="user avatar"></span>
      </a>
      <ul class="dropdown-menu dropdown-menu-right">
       <li class="dropdown-item user-details">
        <a href="javaScript:void();">
           <div class="media">
             <div class="avatar"><img class="align-self-start mr-3" src="https://via.placeholder.com/110x110" alt="user avatar"></div>
            <div class="media-body">
              <h6 class="mt-2 user-title"> <?php echo(htmlentities($_SESSION['name']).' '.htmlentities($_SESSION['surname'])); ?> </h6>
              <p class="user-subtitle"> <?php echo(htmlentities($_SESSION['email'])); ?> </p>
            </div>
           </div>
          </a>
        </li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-settings mr-2"></i> Paskyros nustatymai</li>
        <li class="dropdown-divider"></li>
        <li class="dropdown-item"><i class="icon-power mr-2"></i><a href="logout.php">Atsijungti</a></li>
      </ul>
    </li>
  </ul>
</nav>
</header>
<!--End topbar header-->
<div class="clearfix"></div>

  <div class="content-wrapper">
    <div class="container-fluid">

    <div class="row mt-3">
      <div class="col-lg-3">
        <div class="card">
           <div class="card-body">
           <div class="card-title">Pridėkite nauja automobilį</div>
<?php
//Error message if the inputs were wrong
flashMessage();
?>
           <hr>
            <form method="post">
           <div class="form-group">
            <label for="input-6">Markė</label>
            <input type="text" name="make" class="form-control">
           </div>
           <div class="form-group">
            <label for="input-7">Modelis</label>
            <input type="text" name="model" class="form-control ">
           </div>
           <div class="form-group">
            <label for="input-8">Pagaminimo metai</label>
            <input type="text" name="year" class="form-control ">
           </div>
           <div class="form-group">
            <label for="body-type">Kebulo tipas</label>
            <select id="myselectbox" name="body" class="form-control body-type">
<?php
$stmt = $pdo->query("SELECT body_id, type FROM body ORDER BY type");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false)
{
  echo('<option value="0"> -- nepasirinktą reikšmė -- </option>');
  $stmt = $pdo->query("SELECT body_id, type FROM body ORDER BY type");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
    echo('<option value="'.$row['body_id'].'">'.$row['type'].'</option>');
  }
}
 ?>
            </select>
           </div>
           <div class="form-group">
            <label for="fuel-type">Kūro tipas</label>
            <select name="fuel" class="form-control fuel-type">
<?php
$stmt = $pdo->query("SELECT fuel_id, type FROM fuel ORDER BY type");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false)
{
  echo('<option value="0"> -- nepasirinktą reikšmė -- </option>');
  $stmt = $pdo->query("SELECT fuel_id, type FROM fuel ORDER BY type");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
    echo('<option value="'.$row['fuel_id'].'">'.$row['type'].'</option>');
  }
}
 ?>
            </select>
           </div>
           <div class="form-group">
            <label for="gearbox-type">Pavarų dežės tipas</label>
            <select name="gearbox" class="form-control gearbox-type">
<?php
$stmt = $pdo->query("SELECT gearbox_id, type FROM gearbox ORDER BY type");
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false)
{
  echo('<option value="0"> -- nepasirinktą reikšmė -- </option>');
  $stmt = $pdo->query("SELECT gearbox_id, type FROM gearbox ORDER BY type");
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
    echo('<option value="'.$row['gearbox_id'].'">'.$row['type'].'</option>');
  }
}
 ?>
            </select>
           </div>
           <div class="form-group py-2">
           </div>
           <div class="form-group">
             <input type="submit" class="btn btn-light btn-round px-5" name="add" value="Pridėti">
          </div>
          </form>
         </div>
         </div>
      </div>

      <div class="col-lg-9">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Jūsų automobiliai</h5>
      <div class="table-responsive">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Markė</th>
                  <th scope="col">Modelis</th>
                  <th scope="col">Pagaminimo metai</th>
                  <th scope="col">Kebulo tipas</th>
                  <th scope="col">Kūro tipas</th>
                  <th scope="col">Pavarų dežės tipas</th>
                </tr>
              </thead>
              <tbody>
<?php
$stmt = $pdo->prepare('SELECT * FROM autos WHERE user_id = :uid');
$stmt->execute(array( ':uid' => $_SESSION['uid']));
$nr = 1;
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row !== false)
{
  $stmt = $pdo->prepare("SELECT * FROM autos WHERE user_id = :uid");
  $stmt->execute(array( ':uid' => $_SESSION['uid']));
  while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
  {
    echo('<tr>');
    echo('<th scope="row">'.$nr.'</th>');
    echo('<td>'.htmlentities($row['brand']).'</td>');
    echo('<td>'.htmlentities($row['model']).'</td>');
    echo('<td>'.htmlentities($row['year']).'</td>');
    $stmt2 = $pdo->prepare('SELECT type FROM body WHERE body_id = :bid');
    $stmt2->execute(array( ':bid' => $row['body_id']));
    $temp = $stmt2->fetch(PDO::FETCH_ASSOC);
    echo('<td>'.htmlentities($temp['type']).'</td>');
    $stmt2 = $pdo->prepare('SELECT type FROM fuel WHERE fuel_id = :fid');
    $stmt2->execute(array( ':fid' => $row['fuel_id']));
    $temp = $stmt2->fetch(PDO::FETCH_ASSOC);
    echo('<td>'.htmlentities($temp['type']).'</td>');
    $stmt2 = $pdo->prepare('SELECT type FROM gearbox WHERE gearbox_id = :gid');
    $stmt2->execute(array( ':gid' => $row['gearbox_id']));
    $temp = $stmt2->fetch(PDO::FETCH_ASSOC);
    echo('<td>'.htmlentities($temp['type']).'</td>');
    echo('</tr>');
    $nr++;
  }
}
else
{
    echo('<tr>');
    echo('<td colspan="7">Įrašų nėra</td>');
    echo('</tr>');
}
 ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
      </div>
    </div><!--End Row-->

	<!--start overlay-->
		  <div class="overlay toggle-menu"></div>
		<!--end overlay-->

    </div>
    <!-- End container-fluid-->

   </div><!--End content-wrapper-->
   <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

	<!--Start footer-->
	<footer class="footer">
      <div class="container">
        <div class="text-center">
          Copyright © 2021 Genius solutions
        </div>
      </div>
    </footer>
	<!--End footer-->

  <!--start color switcher-->
   <div class="right-sidebar">
    <div class="switcher-icon">
      <i class="zmdi zmdi-settings zmdi-hc-spin"></i>
    </div>
    <div class="right-sidebar-content">

      <p class="mb-0">Gaussion Texture</p>
      <hr>

      <ul class="switcher">
        <li id="theme1"></li>
        <li id="theme2"></li>
        <li id="theme3"></li>
        <li id="theme4"></li>
        <li id="theme5"></li>
        <li id="theme6"></li>
      </ul>

      <p class="mb-0">Gradient Background</p>
      <hr>

      <ul class="switcher">
        <li id="theme7"></li>
        <li id="theme8"></li>
        <li id="theme9"></li>
        <li id="theme10"></li>
        <li id="theme11"></li>
        <li id="theme12"></li>
    <li id="theme13"></li>
        <li id="theme14"></li>
        <li id="theme15"></li>
      </ul>

     </div>
   </div>
  <!--end color switcher-->

  </div><!--End wrapper-->


  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>

 <!-- simplebar js -->
  <script src="assets/plugins/simplebar/js/simplebar.js"></script>
  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>

  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>

</body>
</html>
