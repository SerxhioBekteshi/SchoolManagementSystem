<?php
include_once 'functions.php';
require_once 'header.php';
include_once 'prof_header.php';
$emaili = $_SESSION['user'];
$mesues_id = $_SESSION['mesues_id'];

if (isset($_POST['kerkesat'])) {
    $klase_lende_id = $_POST['student_klas_selector'];
    $subject_id = $_POST['lenda'];
    $_SESSION['student_klas_selector']=$klase_lende_id;
    $_SESSION['lenda']=$subject_id;
    header("Location: add_result.php");

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
<input type="checkbox" id="check" name="">
<!-------------------------HEADER--------------------------------------->
<header>
    <label for="check">
        <i class="fa fa-bars" id="sidebar_btn"></i>
    </label>
    <div class="left_area">
        <h4> F<span>TI </span></h4>
    </div>
    <div class="right_area">
        <a href="logout.php" class="logout_btn">Logout </a>
    </div>
</header>
<!-------------------------SIDEBAR-i--------------------->
<div class="sidebar">
    <div class="profile_info">
        <img src="ikone.png" class="std">
        <h5><i>Student</i></h5>
    </div>
    <a href="ndryshoP.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
    <a href="prezenca.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Merr mungesat</span></a>
    <a href="vleresimi.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Vlereso</span></a>
    <a href="shfaqInfo.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shfaq notat dhe mungesat</span></a>
    <a href="#"><i class="fa fa-plus" aria-hidden="true"></i><span>Aplikime ne Sekretari</span></a>


</div>
<!------------------------------CONTENT------------------------------->
<!------------------------------CONTENT------------------------------->
<div class="content">

    <div class="permbajtja">


        <br><br><br><br><br><br><br>


        <input type="hidden" class="teacher_email" value="<?php echo $emaili; ?>">

        <div class="container">
            <div class="row">
                <form action="vleresimi.php" method="post">
                    <div class="row">
                        <label for="student_klas_selector">Zgjidh klasen</label>
                        <select name="student_klas_selector" id="student_klas_selector">
                            <option></option>

                            <?php
                            $queryklasave = "SELECT * FROM klase_lende inner join student_klase on klase_lende.student_klase_id=student_klase.student_klase_id WHERE mesues_id='$mesues_id' and seminar_leksion ='l'";
                            $result_klasave = queryMysql($queryklasave);
                            $klaset = array();
                            while ($row = $result_klasave->fetch_assoc()) {
                                $klaset[$row['student_klase_id']]['student_klase_id'] = $row['student_klase_id'];
                                $klaset[$row['student_klase_id']]['klasa'] = $row['niveli'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
                            }
                            foreach ($klaset as $klaseId => $kl_info) {
                                ?>
                                <option value="<?= $klaseId ?>"><?= $kl_info['klasa'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <label for="lenda">Zgjidh lenden</label>
                        <select name="lenda" id="lenda">
                            <option></option>

                            <?php
                            $querylende = "SELECT * FROM lenda inner join klase_lende on klase_lende.lenda_id=lenda.lenda_id WHERE mesues_id='$mesues_id'";
                            $resultlende = queryMysql($querylende);
                            $lendet = array();
                            while ($row = $resultlende->fetch_assoc()) {
                                $lendet[$row['lenda_id']]['lenda_id'] = $row['lenda_id'];
                                $lendet[$row['lenda_id']]['titulli_lendes'] = $row['titulli_lendes'];
                            }
                            foreach ($lendet as $lendaId => $lenda_info) {
                                ?>
                                <option value="<?= $lendaId ?>"><?= $lenda_info['titulli_lendes'] ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <br>
                    <div class="row">
                        <label for="sezoni_selector">Zgjidh sezonin</label>
                        <select name="sezoni_selector" id="sezoni_selector">
                            <option></option>
                            <option value="mid">Sezoni i dimrit</option>
                            <option value="final">Sezoni i veres</option>
                            <option value="failed">Sezoni i vjeshtes</option>
                        </select>
                    </div>
                    <input type="submit" value="Perzgjidh" id="kerkesat" name="kerkesat">
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
