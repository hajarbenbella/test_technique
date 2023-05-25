<?php
include("header.php");
require_once __DIR__ . '/../../config/database.php';

if (!empty($_POST)) {
    $filename = '';
    $filename2 = '';
    if (!empty($_FILES['file'])) {
        $targetDirectory = 'uploads/'; 
        $file = $_FILES['file']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
    
        $tempName = $_FILES['file']['tmp_name'];
        $path_filename_ext = $targetDirectory . $filename . '.' . $ext;
        if (move_uploaded_file($tempName, $path_filename_ext)) {
            $filename = $filename . '.' . $ext;
        }
    }
    
    if (!empty($_FILES['lettre_motv'])) {
        $targetDirectory = "uploads2/";
        $file = $_FILES['lettre_motv']['name'];
        $path = pathinfo($file);
        $filename2 = $path['filename'];
        
        if (isset($path['extension'])) {
            $ext = $path['extension'];
        } else {
            $ext = ''; 
        }
        
        $tempName2 = $_FILES['lettre_motv']['tmp_name'];
        $path_filename_ext = $targetDirectory . $filename2 . '.' . $ext;
        
        if (move_uploaded_file($tempName2, $path_filename_ext)) {
            $filename2 = $filename2 . '.' . $ext;
        }
    }
    
    $sql = "INSERT INTO candidature(nom, prenom, email, telephone, id_nv_etude, id_nbr_experience, file, lettre_motv, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $a = $pdo->prepare($sql)->execute(
        [$_POST['nom'],
         $_POST['prenom'],
         $_POST['email'],
         $_POST['telephone'],
         $_POST['id_nv_etude'],
         $_POST['id_nbr_experience'],
         $filename,
         $filename2, 
         $_POST['comment']]);
         
$datetime = date('Y-m-d H:i:s');
$sql = "INSERT INTO candidature (date) VALUES ('$datetime')";

if ($a) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Enregistrement effectué avec succès !',
            showConfirmButton: false,
            timer: 1500
        });
    </script>";
}



 
}




$stm = $pdo->query("SELECT id, niveau FROM niveau_etude");
$niveau_etude = $stm->fetchAll(PDO::FETCH_ASSOC);
$stm = $pdo->query("SELECT id, experience FROM nombre_experience");
$nombre_experience = $stm->fetchAll(PDO::FETCH_ASSOC);





?>



<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">
                <div class="text-center">
                  <img src="téléchargement.png" style="width: 185px;" alt="logo">
                  <h4 class="mt-1 mb-5 pb-1">Poster votre candidature</h4>
                </div>
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-outline mb-4">
                  <label class="form-label" for="form2Example11">Nom *</label>
                    <input type="text" id="nam" class="form-control" name="nom" placeholder="Nom " required/>
                  </div>
                  <div class="form-outline mb-4">
                  <label class="form-label" for="form2Example11">Prénom *</label>
                    <input class="form-control" id="prenom" type="prenom" name="prenom" placeholder="Prénom" required="required">
                  </div>
                  <div class="form-outline mb-4">
                  <label class="form-label" for="form2Example11">Adresse email *</label>
                    <input class="form-control" id="email" type="adresse" name="email" placeholder="Adresse email " required="required">
                  </div>
                  <div class="form-outline mb-4">
                  <label class="form-label" for="form2Example11">Téléphone *</label>
                    <input class="form-control" id="telephone" type="telephone" name="telephone" placeholder="Téléphone" required="required">
                  </div>
                  <div class="form-outline mb-4"><label class="form-label" for="form2Example11" required="required">Niveau d'études *</label>
                   
                    <select class="form-control" id="id_nv_etude" name="id_nv_etude" required>
    <option value="" disabled selected hidden>Choisir une option</option>
    <?php foreach ($niveau_etude as $nbr) { ?>
        <option value="<?= $nbr['id'] ?>"><?= $nbr['niveau'] ?></option>
    <?php } ?>
</select>
                  </div>
                  <div class="form-outline mb-4"><label class="form-label" for="form2Example11">Nombre d'années d'expérienceone *</label>
              
                   <select class="form-control" id="id_nbr_experience" name="id_nbr_experience" required>
    <option value="" disabled selected hidden>Choisir une option</option>
    <?php foreach ($nombre_experience as $nbr) { ?>
        <option value="<?= $nbr['id'] ?>"><?= $nbr['experience'] ?></option>
    <?php } ?>
</select>


                  </div>
                  <label for="formFile" class="form-label">Curriculum vitae *</label>
                  <div class="form-outline mb-4">
                    <input  class="form-control" id="file" type="file" name="file" placeholder="Curriculum vitae" accept=".pdf,.doc,.docx" required="required">
                  </div>
                  <label for="formFile" class="form-label">Lettre de motivation </label>
                  <div class="form-outline mb-4">
                    <input class="form-control" id="lettre_motv" type="file" name="lettre_motv" accept=".pdf,.doc" placeholder="Lettre de motivation">
                  </div>
                  <div class="form-outline mb-4"><label class="form-label" for="form2Example11">Commentaire</label>
                    <textarea class="form-control" id="comment" type="comment" name="comment" placeholder="Commentaire"></textarea>
                  </div>
                  <div class="wthree-text">
                    <label class="anim">
                      <input type="checkbox" class="checkbox" required="">
                      <span>J'ai lu et accepté les <a href="">conditions générales d'utilisation</a></span>
                    </label>
                    <div class="clear"></div>
                  </div>
                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Envoyer</button></div>
                </form>
              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h3 class="mb-5">Candidature spontanée</h3>
                <h6 class="mb-5">Rejoigner-nous</6>
                <p class="small mb-0">Responsable, très créatif, positif, dynamique et indépendant ! Vous avez de nombreuses années d'expérience à l'ère du multimédia.
                Vous êtes passionné(e) du web, vous savez duer les appels d'offres pour répondre aux demandes à l'internationale et locale.
                Vous pouvez ensuite vous investir dans des projets innovants au service des grandes marques.</p>
                <p class="small mb-0">Vous aimez travailler en équipe.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




