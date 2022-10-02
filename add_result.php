<?php
include_once 'functions.php';
require_once 'header.php';
include_once 'prof_header.php';
$emaili = $_SESSION['user'];

$klase_lende_id = $_SESSION['klase_lende_selector'];
$mesues_id = $_SESSION['pedagog_id'];

$student_klase_id = $_SESSION['klase_lende'][$klase_lende_id]['id_klase'];
$lenda_id = $_SESSION['klase_lende'][$klase_lende_id]['lenda_id'];



$queryklasave = "SELECT * FROM klasa";
$result_klasave = queryMysql($queryklasave);
$klaset = array();
while ($row = $result_klasave->fetch_assoc()) {
    $klaset[$row['klasa_id']]['klasa_id'] = $row['klasa_id'];
    $klaset[$row['klasa_id']]['klasa'] = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
}
$querylendeve = "SELECT * FROM lenda";
$result_lendeve = queryMysql($querylendeve);
$lendet = array();
while ($row = $result_lendeve->fetch_assoc()) {
    $lendet[$row['lenda_id']]['lenda_id'] = $row['lenda_id'];
    $lendet[$row['lenda_id']]['lenda'] = $row['emertimi'];
}


$select_studentet_query = "SELECT student_id,student_email,emer_mbiemer,kredite FROM student where id_klase='$student_klase_id'";
$student_result = queryMysql($select_studentet_query);
if (!$student_result) {
    alert("Gabim i studentit");
}
$std_array = array();
while ($students = $student_result->fetch_assoc()) {
    if (!isset($std_array[$students['student_id']]['seminare'])) {
        $std_array[$students['student_id']]['seminare'] = 0;
    }
    if (!isset($std_array[$students['student_id']]['mungesa'])) {
        $std_array[$students['student_id']]['mungesa'] = 0;
    }


    $std_array[$students['student_id']]['student_id'] = $students['student_id'];
    $total_students[] = $std_array[$students['student_id']]['student_id'];
    $std_array[$students['student_id']]['emer_mbiemer'] = $students['emer_mbiemer'];
    $std_array[$students['student_id']]['lenda'] = $lendet[$lenda_id]['lenda'];
    $std_array[$students['student_id']]['lenda_id'] = $lenda_id;
    $std_array[$students['student_id']]['student_email'] = $students['student_email'];
    $std_array[$students['student_id']]['kredite'] = $students['kredite'];
    $std_array[$students['student_id']]['klasa'] = $klaset[$student_klase_id]['klasa'];

    $queryPerMungesat = "SELECT * FROM mungesa where student_id={$students['student_id']} and klase_lende_id= '$klase_lende_id'";
    $resultpermungesat = queryMysql($queryPerMungesat);

    while ($row = $resultpermungesat->fetch_assoc()) {
        if ($row['student_id'] == $students['student_id'] ) {
            $std_array[$students['student_id']]['seminare']++;
        }

        if ($row['prezent'] == 'jo' && $row['student_id'] == $students['student_id']) {
            $std_array[$students['student_id']]['mungesa']++;
        }

    }
}
foreach ($std_array as $std_id=> $std_info){
    $mungesa=$std_info['mungesa'];
    $seminare=$std_info['seminare'];
    if($seminare!=0) {
        $perqindja = $mungesa / $seminare;
    }else{
        $perqindja=0;
    }
    if($perqindja>0.25){
        $fitues='jo';
    }else{
        $fitues='po';
    }

    // $check_if_exists="SELECT * FROM fitues_provimi where student_id='$std_id' AND klase_lende_id = '$klase_lende_id' AND prof_id='$mesues_id' AND fitues='$fitues'";
    // $check_if_exists_result=queryMysql($check_if_exists);
    // if(!$check_if_exists_result){
    //     echo "ERROR";
    // }else{
    //     $nums=$check_if_exists_result->num_rows;
    //     if($nums==0){
    //         $fitues_query="INSERT INTO fitues_provimi SET student_id='$std_id', klase_lende_id = '$klase_lende_id', prof_id='$mesues_id', fitues='$fitues'";
    //         $fitues_result=queryMysql($fitues_query);
    //         if(!$fitues_result){
    //             echo "ERROR";
    //         }
    //     }
    // }


}

/**
 * Ndertimi i arrayt per fitues provimi
 */
// $fitues_provimi = array();
// $fitues_provimi_query = "SELECT * from fitues_provimi ";
// $fitues_provimi_result = queryMysql($fitues_provimi_query);
// while ($row = $fitues_provimi_result->fetch_assoc()) {
//     $fitues_provimi[$row['klase_lende_id']]['studentet'][$row['student_id']]['student_id'] = $row['student_id'];
//     $fitues_provimi[$row['klase_lende_id']]['studentet'][$row['student_id']]['fitues_provimi_id'] = $row['id'];
//     $fitues_provimi[$row['klase_lende_id']]['studentet'][$row['student_id']]['klase_lende_id'] = $row['klase_lende_id'];
//     $fitues_provimi[$row['klase_lende_id']]['studentet'][$row['student_id']]['fitues'] = $row['fitues'];
//     $fitues_provimi[$row['klase_lende_id']]['studentet'][$row['student_id']]['perfundoi'] = $row['perfundoi'];
// }
//print_array($fitues_provimi);exit;

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
            if($nota==4){
                $fitues_up="po";
                $perfundoi_up="jo";
            }else{
                $fitues_up="po";
                $perfundoi_up="po";
            }
            $insert_provim="INSERT INTO provim (studenti_id , pedagog_id ,email_pedagog,viti_provimit,nota,lenda_id ,klase_lende_id ) VALUES ('$student_id','$mesues_id','$emaili','$dataprovimit','$nota','$lenda_id','$kli') ";
            $result_id=queryMysql($insert_provim);
            if(!$result_id){
                echo 'Gabim';
            }
            // $update_fitues_provimi="UPDATE fitues_provimi set fitues='$fitues_up',perfundoi='$perfundoi_up' WHERE klase_lende_id='$kli' AND student_id='$student_id'";
            // $result_fitues_provimi=queryMysql($update_fitues_provimi);
            // if(!$result_fitues_provimi){
            //     echo 'Gabim';
            // }
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
        <h2> Vlereso klasen</h2><br> <?php


        ?>
        <form method="post" action="add_result.php">
            Data: <input type="date" name="dataprovimit" required> <br><br>
            <?php
            // foreach ($std_array as $stud_id => $stud_info) {
            //     if (isset ($fitues_provimi[$klase_lende_id]['studentet'][$stud_info['student_id']]['perfundoi'])
            //         && $fitues_provimi[$klase_lende_id]['studentet'][$stud_info['student_id']]['perfundoi'] == 'po') {
            //         continue;
            //     }
                ?>

                <label for="nota_e_studentit"><?= $stud_info['emer_mbiemer'] ?></label>
                <?php if ($fitues_provimi[$klase_lende_id]['studentet'][$stud_info['student_id']]['fitues'] == 'po') { ?>
                    <input type="number" max="10" min="4" name="nota_e_studentit_<?= $stud_info['student_id'] ?>"
                           id="nota_e_studentit_<?= $stud_info['student_id'] ?>">
                <?php } else { ?>
                    <input type="number" max="10" min="4" name="nota_e_studentit_<?= $stud_info['student_id'] ?>"
                           id="nota_e_studentit_<?= $stud_info['student_id'] ?>" value="4" readonly>
                <?php } ?>
                <input type="hidden" id="kli" name="kli" value="<?= $klase_lende_id ?>">
                <br>
            <?php  ?>
            <input type="submit" name="dergoNotat">
        </form>
    </div>
</div>

</body>
</html>
