<!DOCTYPE html>
<?php
include_once 'header.php';
include_once 'sek_header.php';
$showTableQuery = "SELECT * FROM student INNER JOIN user ON user.user_email = student.student_email INNER JOIN student_klase ON student_klase.student_klase_id = student.student_klase_id WHERE 1=1 ";
$resultStudent = queryMysql($showTableQuery);
$student = array();
$niveli = array();
$dega = array();
$viti = array();
$grupi = array();

$result = queryMysql("SELECT * FROM student_klase");
$rowCount = $result->num_rows;
while ($row = $result->fetch_assoc()) {
    $niveli[$row['niveli']]['niveli'] = $row['niveli'];
    $dega[$row['dega']]['dega'] = $row['dega'];
    $viti[$row['viti']]['viti'] = $row['viti'];
    $grupi[$row['grupi']]['grupi'] = $row['grupi'];
}
while ($row = $resultStudent->fetch_assoc()) {
    $student[$row['student_email']]['student_email'] = $row['student_email'];
    $student[$row['student_email']]['emer_mbiemer'] = $row['emer_mbiemer'];
    $student[$row['student_email']]['atesia'] = $row['atesia'];
    $student[$row['student_email']]['student_adresa'] = $row['student_adresa'];
    $student[$row['student_email']]['cel'] = $row['cel'];
    $student[$row['student_email']]['student_id'] = $row['student_id'];
    $student[$row['student_email']]['dob'] = $row['dob'];
    $student[$row['student_email']]['gjinia'] = $row['gjinia'];
    $student[$row['student_email']]['status'] = $row['status'];
    $student[$row['student_email']]['kredite'] = $row['kredite'];
    $student[$row['student_email']]['niveli'] = $row['niveli'];
    $student[$row['student_email']]['dega'] = $row['dega'];
    $student[$row['student_email']]['viti'] = $row['viti'];
    $student[$row['student_email']]['grupi'] = $row['grupi'];

}
//echo "<pre>";
//print_r($student);
//exit;
ksort($grupi);

if (isset($_POST['submitForma'])) {
    $error = "";

    $emri = sanitizeString($_POST['emri']);
    $mbiemri = sanitizeString($_POST['mbiemri']);
    $emer_mbiemer = $emri . " " . $mbiemri;
    $atesia = sanitizeString($_POST['atesia']);
    $month = $_POST['month'];
    $dt = $_POST['dt'];
    $year = $_POST['year'];
    $date = "$year-$month-$dt";
    $email = sanitizeString($_POST['email']);
    $cel = sanitizeString($_POST['cel']);
    $gjinia = $_POST['gjinia'];
    $roli = 'student';
    $klasa_id = ($_POST['klasa']);
    $pass = generateRandomString();
    $password = passwordify($pass);
    $status = "Aktiv";
    $kredite = 0;
    $adresa = sanitizeString($_POST['adresa']);
    if (($emri == "") && ($mbiemri == "") && ($atesia == "") && ($email == "") && ($date == "") && ($cel == "") && ($gjinia == "") && ($password == ""))
        $error = 'Nuk jane futur gjithe te dhenat<br><br>';
    else {
        $result = queryMysql("SELECT * FROM user WHERE user_email='$email'");
        $rowCount = $result->num_rows;
        $insertUserQuery = "INSERT INTO user (user_email,user_password,user_role,user_emri,user_mbiemri) VALUES('$email', '$password','$roli','$emri','$mbiemri')";
        $insertStudentQuery = "INSERT INTO student (student_email, emer_mbiemer,student_klase_id,student_adresa,cel,atesia, dob, gjinia, status, kredite) VALUES('$email', '$emer_mbiemer','$klasa_id','$adresa','$cel','$atesia','$date','$gjinia','$status','$kredite')";
        if ($rowCount != 0)
            $error = 'Eshte nje student i regjistruar me kete email.<br><br>';
        else {
            if (queryMysql($insertUserQuery) && queryMysql($insertStudentQuery)) {
                echo("U ruajt studenti");
                mail("$email", 'Regjistrimi', "I nderuar $emer_mbiemer, passwordi juaj eshte: $pass!", 'Sekretaria FTI');
            } else {
                echo "Gabim:$error";
            }
        }
    }

}

if (isset($_POST['butoni_fshirjes'])) {
    $email = $_POST['fshij_student'];
    echo $email;
    $fshijQuery = "DELETE FROM student WHERE student_email ='$email'";
    $fshijQuery2 = "DELETE FROM user WHERE user_email ='$email'";
    $result = queryMysql($fshijQuery);
    $result2 = queryMysql($fshijQuery2);
}
if (isset($_POST['edit_student'])) {
    $emri = sanitizeString($_POST['emri_modal']);
    $email_old = sanitizeString($_POST['email_id_modal']);
    $mbiemri = sanitizeString($_POST['mbiemri_modal']);
    $emrimbiemri = $emri . ' ' . $mbiemri;
    $adresa = sanitizeString($_POST['adresa_modal']);
    $emri = sanitizeString($_POST['emri_modal']);
    $cel = sanitizeString($_POST['cel_modal']);
    $statusi = $_POST['statusi_modal'];
    $kredite = sanitizeString($_POST['kredite_modal']);
    $grupi_id = sanitizeString($_POST['grupi_modal']);

    $update_user_query = "UPDATE user SET user_emri='$emri', user_mbiemri='$mbiemri' WHERE user_email='$email_old'";
    $update_student_query = "UPDATE student SET emer_mbiemer='$emrimbiemri', student_klase_id='$grupi_id',student_adresa='$adresa',cel='$cel',status='$statusi',kredite='$kredite' WHERE student_email='$email_old'";

    if (!queryMysql($update_user_query)) {
        echo('Gabim user');
    }
    if (!queryMysql($update_student_query)) {
        echo('Gabim student');

    }
}
?>




<!---------------------------------KODI HTML------------------------------------>

<html>
<head>
    <meta charset="utf-8">
    <title>UPLOAD</title>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="sekretaria.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="student.js"></script>
</head>
<body>


<!-------------------------HEADER--------------------------------------->
<div class="content">
    <div  class="container-fluid my-auto">
         <div class="d-flex shadow"> 
    	    <div class="col-md-8">
		        <div class="panel panel-default" style="margin-top:100px;">
			        <div class="panel-body">
				        <table id="table" class="table table-bordered table-striped table-hover" >
					       
					        <thead class="table-dark">
						        <tr>
							        <th>Emri i Dokumentit</th>
							        <th>Tipi i Dokumentit</th>
							        <th>Data </th>
							        <th>Veprime</th>
						        </tr>
					        </thead>
                    
					        <tbody>
						     	
					        </tbody>
				        </table>
			        </div>
		        </div>
	        </div>
        </div>    
    </div>
</div>



<!------------------------------VERTETIM STUDENTI -----------------> 
 
<script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<link rel="stylesheet" type="text/css"
      href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">





</body>

<!-- Footer -->
<footer class="">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2021 Copyright:
    <a href="http://upt.al/"> UPT| FTI</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
</html>