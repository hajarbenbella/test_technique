<?php
require_once __DIR__ . '/../../config/database.php';

if (isset($_GET['id']) && isset($_GET['file'])) {
  $id = $_GET['id'];
  $fileType = $_GET['file'];

  $sql = "SELECT * FROM candidature WHERE id = :id";
  $statement = $pdo->prepare($sql);
  $statement->bindValue(':id', $id);
  $statement->execute();

  if ($statement->rowCount() > 0) {
    $file = $statement->fetch(PDO::FETCH_ASSOC);
    $filename = "";

    if ($fileType === 'CV') {
      $filepath = "uploads/" . $file['file'];
      $filename = $file['file'];
    } elseif ($fileType === 'motivation') {
      $filepath = "uploads2/" . $file['lettre_motv'];
      $filename = $file['lettre_motv'];
    }

    if (file_exists($filepath)) {
      header('Content-Type: application/octet-stream');
      header('Content-Description: File Transfer');
      header('Content-Disposition: attachment; filename=' . basename($filename));
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($filepath));
      readfile($filepath);

      $newCount = $file['show'] + 1;
      $updateQuery = "UPDATE candidature SET `show` = :newCount WHERE id = :id";
      $updateStatement = $pdo->prepare($updateQuery);
      $updateStatement->bindValue(':newCount', $newCount);
      $updateStatement->bindValue(':id', $id);
      $updateStatement->execute();

      exit;
    }
  }
}

$stm = $pdo->query("SELECT candidature.*, niveau_etude.niveau, nombre_experience.experience FROM candidature LEFT JOIN niveau_etude ON niveau_etude.id = candidature.id_nv_etude LEFT JOIN nombre_experience ON nombre_experience.id = candidature.id_nbr_experience");

$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>
<body>
  <div class="container">
    <table class="display" id="tab">
      <thead>
        <tr>
          <th>#</th>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Adresse email</th>
          <th>Téléphone</th>
          <th>Niveau d'études</th>
          <th>Nombre d'années d'expérience</th>
          <th>Curriculum vitae</th>
          <th>Lettre de motivation</th>
          <th>Commentaire</th>
          <th>Date</th>
          <th>Adresse IP</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row) {
          $id = $row['id'];
          $nom = $row['nom'];
          $prenom = $row['prenom'];
          $email = $row['email'];
          $telephone = $row['telephone'];
          $id_nv_etude = $row['niveau'];
          $id_nbr_experience = $row['experience'];
          $file = $row['file'];
          $lettre_motv = $row['lettre_motv'];
          $comment = $row['comment'];
          $date = $row['date'];
          ?>
          <tr>
            <td><?php echo $id; ?></td>
            <td><?php echo $nom; ?></td>
            <td><?php echo $prenom; ?></td>
            <td><?php echo $email; ?></td>
            <td><?php echo $telephone; ?></td>
            <td><?php echo $id_nv_etude; ?></td>
            <td><?php echo $id_nbr_experience; ?></td>
            <td><a href="uploads/<?php echo $file; ?>" download><?php echo $file; ?></a></td>
            <td><a href="uploads2/<?php echo $lettre_motv; ?>" download><?php echo $lettre_motv; ?></a></td>
            <td><?php echo $comment; ?></td>
            <td><?php echo $date; ?></td>
            <td><?php echo 'IP ' . $_SERVER['REMOTE_ADDR']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script>
    $(document).ready(function () {
      $('#tab').DataTable({
        scrollY: 450,
        scrollX: true,
      });
    });
  </script>
</body>
</html>
