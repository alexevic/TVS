<?php
  // To check if user is logged in
  function isLoggedIn() {
    if(!((isset($_SESSION["name"])) && (strlen($_SESSION["name"]) > 0)))
    {
      $_SESSION["error"] = "Turite prisijungti, norėdami pasiekti šį puslapį.";
      header("Location: login.php");
      return;
    }
  }

  // When cancel is pressed
  function isCancel() {
    if(isset($_POST["cancel"]))
    {
      header("Location: index.php");
      return;
    }
  }

  // Guardian: Make sure that profile_id is present
  function Guardian()
  {
    if(!isset($_GET["auto_id"]))
    {
      $_SESSION["error"] = "Missing auto_id";
      header('Location: index.php');
      return;
    }
  }

  // Flash messages
  function flashMessage()
  {
    if(isset($_SESSION["success"]))
    {
      echo('<p style="color: green;">'.$_SESSION["success"]."</p>\n");
      unset($_SESSION["success"]);
    }

    if(isset($_SESSION["error"]))
    {
      echo('<p style="color: red;">'.$_SESSION["error"]."</p>\n");
      unset($_SESSION["error"]);
    }
  }

  // Input data for profile validation
  function validateRegistration()
  {
    // First we check are all the fields filled with data, if not then program will return
    if((strlen($_POST["firstName"]) < 1) || (strlen($_POST["lastName"]) < 1) || (strlen($_POST["email"]) < 1) || (strlen($_POST["pass"]) < 1))
    {
      return "Visi laukai yra privalomi.";
    }

    // Email verification
    if((strpos($_POST["email"], '@') === false) || (strpos($_POST["email"], '.') === false))
    {
      return "Netinkamas el. pašto adresas.";
    }

    if(strlen($_POST["pass"]) < 6)
    {
      return "Slaptažodį turi sudaryti bent 6 simboliai.";
    }
  }

  function validateTerms()
  {
    if(!isset($_POST["test1"]))
    {
      return "Nesutikote su svetainės taisyklėmis.";
    }
  }
