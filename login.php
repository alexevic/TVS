<?php
  session_start();
  require_once "pdo.php";
  require_once "utility_functions.php";

  if(isset($_POST["login"]))
  {
    $salt = 'XyZzy13*_';
    if(isset($_POST["email"]) && isset($_POST["pass"]))
    {
      unset($_SESSION["email"]); // Atjungiam dabartinį naudotoją
      if((strlen($_POST["email"]) < 1) || (strlen($_POST["pass"]) < 1))
      {
        $_SESSION["error"] = "Ne visi laukai buvo užpildyti.";
        header("Location: login.php");
        return;
      }
      else
      {
        $stmt = $pdo->prepare('SELECT user_id, name, surname FROM users WHERE email = :em AND password = :pw');
        $stmt->execute(array(
          ':em' => $_POST['email'],
          ':pw' => hash('md5', $salt.$_POST['pass'])));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row !== false)
        {
          $_SESSION['uid'] = $row["user_id"];
          $_SESSION['name'] = $row['name'];
          $_SESSION['surname'] = $row['surname'];
          $_SESSION['email'] = $_POST['email'];
          header("Location: index.php");
          return;
        }
        else
        {
          $_SESSION["error"] = "Klaidingas el. paštas arba slaptažodis!";
          header("Location: login.php");
          return;
        }
      }
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
  <title>Genius solutions - Prisijungimas</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet"/>
  <script src="assets/js/pace.min.js"></script>
  <!--favicon-->
  <link rel="icon" href="assets/images/faviconn.ico" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="assets/css/app-style.css" rel="stylesheet"/>
  <!-- Mano Stiliai-->
  <link href="assets/css/my-style.css" rel="stylesheet"/>
  <!-- Mano Scriptai-->
  <script src="assets/js/manoscriptai.js"></script>

</head>

<body class="bg-theme bg-theme4">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">

 <div class="loader-wrapper"><div class="lds-ring"><div></div><div></div><div></div><div></div></div></div>
	<div class="card card-authentication1 mx-auto my-5">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/logo.png" alt="logo icon" height="68px">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Prisijungimas</div>
<?php
  //Error message if the inputs were wrong
  flashMessage();
 ?>
        <form method="post">
			  <div class="form-group">
			  <label for="email" class="sr-only">Email</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="email" id="em" class="form-control input-shadow" placeholder="El. paštas">
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="exampleInputPassword" class="sr-only">Password</label>
			   <div class="position-relative has-icon-right">
				  <input type="password" name="pass" id="psw" class="form-control input-shadow" placeholder="Slaptažodis">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
			<div class="form-row">
			 <div class="form-group col-6">
			   <div class="icheck-material-white">

			  </div>
			 </div>
			 <div class="form-group col-6 text-right">
			  <a href="reset-password.php">Pamiršau slaptažodį</a>
			 </div>
			</div>
			 <input type="submit" class="btn btn-light btn-block waves-effect waves-light" name="login" onclick="return doValidate();" value="Prisijungti">

			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <p class="text-warning mb-0">Neturite paskyros? <a href="register.php"> Registruokitės</a></p>
		  </div>
	     </div>

     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->

	</div><!--wrapper-->

  <!-- Bootstrap core JavaScript-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/popper.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>

  <!-- sidebar-menu js -->
  <script src="assets/js/sidebar-menu.js"></script>

  <!-- Custom scripts -->
  <script src="assets/js/app-script.js"></script>

</body>
</html>
