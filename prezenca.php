<?php
include_once 'functions.php';
require_once 'header.php';
$emaili = $_SESSION['user'];
$mesues_id = $_SESSION['pedagog_id'];

include_once 'prof_header.php';


error_reporting(E_ERROR | E_PARSE);

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>User Pedagog | Sekretaria Mesimore</title>
        <link rel="stylesheet" type="text/css" href="sekretaria2.css">
        <link rel="stylesheet" type="text/css" href="student.js">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
            <h5><i>Pedagog</i></h5>
        </div>
        <a href="ndryshoP.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="vleresimi.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Veprime</span></a>
        <a href="shfaqInfo.php"><i class="fa fa-graduation-cap"
                                   aria-hidden="true"></i><span>Shfaq notat dhe mungesat</span></a>


    </div>
    <!------------------------------CONTENT------------------------------->
    <!------------------------------CONTENT------------------------------->
<div class="content">

    <div class="permbajtja">



    <form action="prezenca.php" method="post">
        <div class="col-md-6 col-md-offset-3">
            <div class="form-group">
                <label for="">Select Date</label>
                <input type="date" name="dita_seminarit" class="custom-date select_date form-control" required
                       autocomplete="off">
            </div>
        </div>

        <div id="error-msg"></div>

        <table border="1" class="table table-bordered table-stripped make-hidden">
            <thead>
            <tr>
                <th>Student ID</th>
                <th>Email</th>
                <th>Emri</th>
                <th>Klasa</th>
                <th>Zgjidhni nxenesit prezent</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $klase_lende_id = $_SESSION['klase_lende_selector'];
            $student_klase_id = $_SESSION['klase_lende'][$klase_lende_id]['id_klase'];
            $lenda_id = $_SESSION['klase_lende'][$klase_lende_id]['lenda_id'];

            $queryklasave = "SELECT * FROM klasa";
            $result_klasave = queryMysql($queryklasave);
            $klaset = array();
            while ($row = $result_klasave->fetch_assoc()) {
                $klaset[$row['student_klase_id']]['student_klase_id'] = $row['klasa_id'];
                $klaset[$row['student_klase_id']]['klasa'] = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
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

                $std_array[$students['student_id']]['student_id'] = $students['student_id'];
                $total_students[] = $std_array[$students['student_id']]['student_id'];
                $std_array[$students['student_id']]['emer_mbiemer'] = $students['emer_mbiemer'];
                $std_array[$students['student_id']]['lenda'] = $lendet[$lenda_id]['lenda'];
                $std_array[$students['student_id']]['lenda_id'] = $lenda_id;
                $std_array[$students['student_id']]['student_email'] = $students['student_email'];
                $std_array[$students['student_id']]['kredite'] = $students['kredite'];
                $std_array[$students['student_id']]['klasa'] = $klaset[$student_klase_id]['klasa'];

            }

            foreach ($std_array as $key => $value) {
                echo "<tr>"; ?>
                <td><?= $value['student_id'] ?></td>
                <td><?= $value['emer_mbiemer'] ?></td>
                <td><?= $value['lenda'] ?></td>
                <td><?= $value['klasa'] ?></td>"<?php
                echo "<td>
							<input type='checkbox' class='form-control student_id' name='attendance[]' std_id='{$value['student_id']}' std-roll='{$value['student_id']}'>
							<input type='hidden' class='student-{$value['student_id']}' name='myid[]' value=''>

						</td>";
                echo "</tr>";
            }
            ?>
            <tr></tr>
            <tr>
                <td colspan="4" class="text-center">
                    <input type="submit" name="attendance_submit" class="btn btn-info" value="Submit">
                </td>
            </tr>
            </tbody>
        </table>
    </form>

    <script>
        $(document).ready(function () {

            $('.select_date').on('change', function () {
                $("#error-msg").empty();

                var datess = $(this).val();
                var classs = $('#thisclass').val();
                $.ajax({
                    url: 'attendance_checker.php',
                    type: 'POST',
                    data: {classs: classs, datess: datess},
                    success: function (data) {
                        if (data) {
                            $('.make-hidden').hide();
                            $('.success-msg').hide();
                            $("#error-msg").html("<div class='col-md-12 text-center'><h3>Attendance taken on this day.</h3></div>");
                        } else {
                            $('.make-hidden').show();
                        }
                    }
                });

            });

            $('.student_id').on('click', function () {
                var checked = $(this).attr('std_id');

                if ($(this).prop('checked') == true) {
                    $(this).attr('value', checked);
                } else {
                    $(this).attr('value', '');
                }
            });
        });
    </script>


<?php
if (isset($_POST['attendance_submit']) && isset($_POST['attendance'])) {

    $students_attendance = $_POST['attendance'];
    $class_date = $_POST['dita_seminarit'];


    foreach ($std_array as $key => $student) {
        if (in_array($key, $students_attendance)) {
            $attendance_val = "po";
        } else {
            $attendance_val = "jo";
        }
        $query = "INSERT INTO mungesa (data, student_id, klase_lende_id, pedagog_id, prezent) VALUES ('$class_date', '$key', '$klase_lende_id', '$mesues_id', '$attendance_val')";
        $result = queryMysql($query);
        if (!$result) {
            die("Nuk u shtua");
        }
    }
    echo "<div class='col-md-12 text-center success-msg'><h3>Done!</h3></div>";
}


?>