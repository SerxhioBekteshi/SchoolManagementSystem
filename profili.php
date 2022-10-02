<?php
require_once 'header.php';
if (!$loggedin) die("</div></body></html>");

echo "<h3>Profili juaj</h3>";

$result = queryMysql("SELECT roli FROM `user` WHERE user_email='$user'");
$rowCount = $result->num_rows;
if ($rowCount == 0)
{
    $error = "Invalid login attempt";
}
$roli="";
if ($rowCount == 1)
{
    $roli = $_SESSION['roli'] = $result->fetch_assoc()["roli"];
}

if(strtolower($roli)=='sekretar' || strtolower($roli)=='admin'){
    header("Location: sek_header.php");

}
if(strtolower($roli)=='pedagog'){

    $select_prof_id_query="SELECT pedagog_id from pedagog where email='$user'";
    $result_id=queryMysql($select_prof_id_query);
    $result=$result_id->fetch_assoc();
    $pedagog_id=$result['pedagog_id'];
    $_SESSION['pedagog_id']=$pedagog_id;

    /**
     * selektojme array me klaset
     */
    $array_klase=array();
    $select_classes="SELECT * FROM klase_lende where pedagog_id='$pedagog_id'";
    $result_classes=queryMysql($select_classes);
    while($row=$result_classes->fetch_assoc()) {
        $array_klase[$row['klase_lende_id']]['klase_lende_id'] = $row['klase_lende_id'];
        $array_klase[$row['klase_lende_id']]['id_klase'] = $row['id_klase'];
        $array_klase[$row['klase_lende_id']]['lenda_id'] = $row['lenda_id'];
        $array_klase[$row['klase_lende_id']]['pedagog_id'] = $row['pedagog_id'];
        $array_klase[$row['klase_lende_id']]['kredite'] = $row['kredite'];
        $array_klase[$row['klase_lende_id']]['semestri'] = $row['semestri'];
    }
    $_SESSION['klase_lende']=$array_klase;


    header("Location: prof_header.php");

}if(strtolower($roli)=='student'){
    $select_stud_id_query="SELECT student_id, id_klase from student where student_email='$user'";
    $result_id=queryMysql($select_stud_id_query);
    $result=$result_id->fetch_assoc();
    $student_id=$result['student_id'];
    $student_klase_id=$result['id_klase'];
    $_SESSION['student_id']=$student_id;

    /**
     * selektojme array me klaset
     */
    $array_klase=array();
    $select_classes="SELECT * FROM klase_lende where id_klase='$student_klase_id'";
    $result_classes=queryMysql($select_classes);
    while($row=$result_classes->fetch_assoc()) {
        $array_klase[$row['klase_lende_id']]['klase_lende_id'] = $row['klase_lende_id'];
        $array_klase[$row['klase_lende_id']]['id_klase'] = $row['id_klase'];
        $array_klase[$row['klase_lende_id']]['lenda_id'] = $row['lenda_id'];
        $array_klase[$row['klase_lende_id']]['pedagog_id'] = $row['pedagog_id'];
        $array_klase[$row['klase_lende_id']]['kredite'] = $row['kredite'];
        $array_klase[$row['klase_lende_id']]['semestri'] = $row['semestri'];
    }
    $_SESSION['klase_lende']=$array_klase;


    header("Location: stud_header.php");

}

?>
