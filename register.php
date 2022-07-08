<?php
  session_start();
  require_once "pdo.php";
  require_once "utility_functions.php";

  //isCancel();

  //*** Įrašytų reikšmių patikrinimas ***//
  if(isset($_POST["register"]))
  {
    if(isset($_POST["firstName"]) && isset($_POST["lastName"]) && isset($_POST["email"]) && isset($_POST["pass"]))
    {
      //*** Tikrinama ar teisingi įvesti duomenys ***//
      $msg = validateRegistration();
      if(is_string($msg))
      {
        $_SESSION["error"] = $msg;
        header("Location: register.php");
        return;
      }

      //*** Tikrinama ar naudotojas sutiko su puslapio politikos taisyklėmis ***//
      $msg = validateTerms();
      if(is_string($msg))
      {
        $_SESSION["error"] = $msg;
        header("Location: register.php");
        return;
      }

      //*** Tikrinama ar egzistuoja jau toks vartotojas pagal el. paštą ***//
      $user_id = false;
      $stmt = $pdo-> prepare('SELECT user_id FROM users WHERE email = :email');
      $stmt->execute(array(
        ':email' => $_POST['email']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row !== false)
      {
        $user_id = $row['user_id'];
      }

      //*** Jei tokio vartotojo dar nėra, jis sukuriamas, kitų atveju išvedamas klaidos pranešimas ***//
      if($user_id === false)
      {
        $salt = 'XyZzy13*_';
        $stmt = $pdo->prepare('INSERT INTO users (name, surname, email, password) VALUES (:fn, :sn, :em, :pw)');
        $stmt->execute(array(
          ':fn' => $_POST['firstName'],
          ':sn' => $_POST['lastName'],
          ':em' => $_POST['email'],
          ':pw' => hash('md5', $salt.$_POST['pass'])));
      }
      else
      {
        $_SESSION["error"] = 'Šis pašto adresas jau yra naudojamas svetainėje. Prisijunkite su <a href="login.php?email='.htmlentities($_POST['email']).'">'.htmlentities($_POST['email']).'</a> arba bandykite dar kartą, naudodami kitą el. pašto adresą.';
        header("Location: register.php");
        return;
      }

      $_SESSION["success"] = "Sveikiname, sėkmingai užsiregistravote!";
      header("Location: login.php");
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
  <title>Genius solutions - Registracija</title>
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

</head>

<body class="bg-theme bg-theme4">

<!-- start loader -->
   <div id="pageloader-overlay" class="visible incoming"><div class="loader-wrapper-outer"><div class="loader-wrapper-inner" ><div class="loader"></div></div></div></div>
   <!-- end loader -->

<!-- Start wrapper-->
 <div id="wrapper">
	<div class="card card-authentication1 mx-auto my-4">
		<div class="card-body">
		 <div class="card-content p-2">
		 	<div class="text-center">
		 		<img src="assets/images/logo.png" alt="logo icon" height="68px">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Registracija</div>
<?php
  //Error message if the inputs were wrong
  flashMessage();
 ?>
        <form method="post">
			  <div class="form-group">
			  <label for="firstName" class="sr-only">Name</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="firstName" class="form-control input-shadow" placeholder="Vardas">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
        <div class="form-group">
			  <label for="lastName" class="sr-only">Surname</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="lastName" class="form-control input-shadow" placeholder="Pavardė">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			  <label for="email" class="sr-only">Email ID</label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="email" class="form-control input-shadow" placeholder="El. paštas">
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			   <label for="pass" class="sr-only">Password</label>
			   <div class="position-relative has-icon-right">
				  <input type="password" name="pass" class="form-control input-shadow" placeholder="Slaptažodis">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
			   </div>
			  </div>
        <br/>
			   <div class="form-group">
			     <div class="icheck-material-white">
                   <input type="checkbox" id="user-checkbox" name="test1" value="value1">
                   <label for="user-checkbox"> Su taisyklėmis susipažinau ir sutinku.</label>
			     </div>
			    </div>
          <input type="submit" class="btn btn-light btn-block waves-effect waves-light" name="register" value="Registruotis">
          <!--
          <br/><br/>
          <input type="submit" class="btn btn-light btn-block waves-effect waves-light" name="cancel" value="Grįžti"> -->
			 </form>
		   </div>
		  </div>
		  <div class="card-footer text-center py-3">
		    <p class="text-warning mb-0">Jau esate užsiregistravės narys? <a href="login.php"> Prisijunkite</a></p>
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
