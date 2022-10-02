<?php
include_once 'functions.php';
require_once 'header.php';
include_once 'prof_header.php';
$emaili = $_SESSION['user'];
$mesues_id = $_SESSION['mesues_id'];
$student_klase_id = $_SESSION['student_klas_selector'];
$lenda_id=$_SESSION['lenda'];

if(isset($_POST['dergoNotat'])){
    $dataprovimit = $_POST['dataprovimit'];
    $kli = $_POST['kli'];
    $student_id_query="SELECT student_id from student";
    $result_id=queryMysql($student_id_query);
    $id_array=array();
    while($row=$result_id->fetch_assoc()){
        $id_array[$row['student_id']]['id']=$row['student_id'];
    }
    foreach($id_array as $id=> $info){
        if(isset($_POST['nota_e_studentit_'.$id])){
            $student_id=$id;
            $nota=$_POST['nota_e_studentit_'.$id];
            $insert_provim="INSERT INTO provim (studenti_id , mesuesi_id ,email_mesues,viti_provimit,nota,lenda_id ,klase_lende_id ) VALUES ('$student_id','$mesues_id','$emaili','$dataprovimit','$nota','$lenda_id','$kli') ";
            $result_id=queryMysql($insert_provim);
            if(!$result_id){
                echo 'Gabim';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css">
    <link rel="stylesheet" type="text/css" href="student.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>

</head>
<body>

<!------------------------------CONTENT------------------------------->
<div class="content">

    <div class="container">


        <br><br><br>
        <?php

        ?> <h2> Vlereso klasen</h2><br> <?php
        $query_studente = "SELECT * FROM student inner join student_klase on student.student_klase_id=student_klase.student_klase_id inner join klase_lende on student_klase.student_klase_id=klase_lende.student_klase_id where klase_lende.student_klase_id='$student_klase_id'";
        $result_studente = queryMysql($query_studente);
        $studentarray = array();
        while ($row = $result_studente->fetch_assoc()) {
            $studentarray[$row['student_id']]['student_id'] = $row['student_id'];
            $studentarray[$row['student_id']]['klase_lende_id'] = $row['klase_lende_id'];
            $studentarray[$row['student_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
        }
        ?> <form method="post" action="add_result.php">
           Data: <input type="date" name="dataprovimit" required> <br><br>
            <?php
        foreach ($studentarray as $stud_id => $stud_info) {
            ?>

            <label for="nota_e_studentit"><?= $stud_info['emer_mbiemer'] ?></label>
            <input type="number" max="10" min="4" name="nota_e_studentit_<?= $stud_info['student_id'] ?>"
                   id="nota_e_studentit_<?= $stud_info['student_id'] ?>">
            <input type="hidden" id="kli" name="kli" value="<?=$stud_info['klase_lende_id'] ?>">
            <br>
        <?php } ?>
        <input type="submit" name="dergoNotat">
    </form>
    </div>
</div>

</body>
</html>
