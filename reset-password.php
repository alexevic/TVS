<?php
  session_start();
  require_once "pdo.php";
  require_once "utility_functions.php";

  if(isset($_POST["send"]))
  {
    if(isset($_POST["email"]))
    {
      if(strlen($_POST["email"]) < 1)
      {
        $_SESSION["error"] = "Neįvedėte savo el. pašto adreso.";
        header("Location: reset-password.php");
        return;
      }
      if((strpos($_POST["email"], '@') === false) || (strpos($_POST["email"], '.') === false))
      {
        $_SESSION["error"] = "Netinkamas el. pašto adresas.";
        header("Location: reset-password.php");
        return;
      }

      //*** Tikrinama ar egzistuoja vartotojas pagal el. paštą ***//
      $user_id = false;
      $stmt = $pdo-> prepare('SELECT user_id FROM users WHERE email = :email');
      $stmt->execute(array(
        ':email' => $_POST['email']));
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if($row !== false)
      {
        $user_id = $row['user_id'];
      }

      //*** Jei tokio vartotojo dar nėra, išvedamas klaidos pranešimas ***//
      if($user_id === false)
      {
        $_SESSION["error"] = "Netinkamas el. pašto adresas.";
        header("Location: reset-password.php");
        return;
      }
      else
      {
        $stmt = $pdo->prepare('INSERT INTO supportticket (email, problem_desc) VALUES (:em, :pd)');
        $stmt->execute(array(
          ':em' => $_POST['email'],
          ':pd' => 'Password reset.'));
      }

      $_SESSION["success"] = "Prašymas sėkmingai išsiustas. Mūsų darbuotojai su Jumis susisieks savaitės bėgyje.";
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
  <title>Genius solutions - Slaptažodžio atstatymas</title>
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet"/>
  <script src="assets/js/pace.min.js"></script>
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

<!-- Start wrapper-->
 <div id="wrapper">

 <div class="height-100v d-flex align-items-center justify-content-center">
	<div class="card card-authentication1 mb-0">
		<div class="card-body">
		 <div class="card-content p-2">
		  <div class="card-title text-uppercase pb-2">Slaptažodžio atstatymas</div>
		    <p class="pb-2">Įveskite savo paskyros el. pašto adresą.</p>
<?php
  //Error message if the inputs were wrong
  flashMessage();
 ?>
        <form method="post">
			  <div class="form-group">
			  <label for="email" class=""></label>
			   <div class="position-relative has-icon-right">
				  <input type="text" name="email" class="form-control input-shadow" placeholder="El. pašto adresas">
				  <div class="form-control-position">
					  <i class="icon-envelope-open"></i>
				  </div>
			   </div>
			  </div>

			  <input type="submit" class="btn btn-light btn-block mt-3" name="send" value="Siųsti užklausą">
			 </form>
		   </div>
		  </div>
		   <div class="card-footer text-center py-3">
		    <p class="mb-0"><a href="login.php">Grįžti į prisijungimą</a></p>
		  </div>
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
