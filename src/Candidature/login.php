<?php
session_start();
@$login = $_POST["login"];
@$pass = $_POST["pass"];
@$valider = $_POST["valider"];
$bonLogin = "user@gm";
$bonPass = "1234";
$erreur = "";
if (isset($valider)) {
  if ($login == $bonLogin && $pass == $bonPass) {
    $_SESSION["autoriser"] = "oui";
    header("location:show.php");
  } else
    $erreur = "Mauvais login ou mot de passe!";
}
?>
<html>

<head>
  <meta charset="utf-8">
  <!-- importer le fichier de style -->
  <link href="./style.css" rel="stylesheet" type="text/css" media="all" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body onLoad="document.fo.login.focus()">
  <div id="container">
    <!-- zone de connexion -->


    <form name="fo" method="post" action="">
      <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
          <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
              <div class="card shadow-2-strong" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">

                  <h3 class="mb-5">S'identifier</h3>

                  <div class="form-outline mb-4">
                    <input type="email" name="login" id="typeEmailX-2" class="form-control form-control-lg" placeholder="Email" require="" />

                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" name="pass" id="typePasswordX-2" class="form-control form-control-lg" require placeholder="mot de passe " />

                  </div>

                  <!-- Checkbox -->
                  <div class="form-check d-flex justify-content-start mb-4">
                    <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                    <label class="form-check-label" for="form1Example3"> Se souvenir du mot de passe </label>
                  </div>
                  <div class="erreur"><?php echo $erreur ?></div>
                  <button class="btn btn-primary btn-lg btn-block" type="submit" name="valider">Login</button>



                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </form>
  </div>
</body>