<?php
    include_once 'functions.php';
    require_once 'header.php';
    include_once 'prof_header.php';
    $emaili = $_SESSION['user'];
    $mesues_id = $_SESSION['pedagog_id'];

    if (isset($_POST['kerkesat'])) 
    {
        $klase_lende_id = $_POST['student_klas_selector'];
        $subject_id = $_POST['lenda'];
        $lloji = $_POST['lloji_selector'];
        $_SESSION['klase_lende_selector'] = $klase_lende_id;
        $dest = '';
        if ($lloji == 'note') 
        {
            $dest = 'add_result.php';
        } 
        else 
        {
            $dest = 'prezenca.php';
        }
        include_once $dest;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> PEDAGOG </title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="student.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <!-- <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script> -->

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
    </header>

    <!-------------------------SIDEBAR-i--------------------->
    <div class="sidebar">
        <div class="profile_info">
            <a href="prof_header.php" id = "piktura" style= "text-align:center">
                <img src="profesor.png" class="std"> </a> 
                    <h5><i>Pedagog</i></h5>
        </div>

        <a href="ndryshoP.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="vleresimi.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Veprime</span></a>
        <a href="shfaqInfo.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shfaq notat dhe mungesat</span></a>

    </div>
<!------------------------------------------------/SIDEBAR-i------------------------------------------------------>
<!------------------------------CONTENT------------------------------->

<div class="content" style="margin:auto;width: 70%">
    <div class="permbajtja">
        <br><br><br><br><br><br><br>

        <input type="hidden" class="teacher_email" value="<?php echo $emaili; ?>">
            <div style="position:relative; left: 30%; ">
                <div class="row">
                    <div class="d-flex shadow" style="height:1000px width:950px; background: lightgrey">
                        <div class="container-fluid my-auto">
                            <div class="row">
                                <div class="col-lg-10">
                                    <form action="vleresimi.php" method="post">
                                        <div class="row">
                                            <br>
                                            <label for="student_klas_selector"><b>Zgjidh klasen</b></label>
                                            <select name="student_klas_selector" id="student_klas_selector">
                                                <option></option>

                                                <?php
                                                $queryklasave = "SELECT * FROM klasa";
                                                $result_klasave = queryMysql($queryklasave);
                                                $klaset = array();
                                                while ($row = $result_klasave->fetch_assoc()) 
                                                {
                                                    $klaset[$row['klasa_id']]['klasa_id'] = $row['klasa_id'];
                                                    $klaset[$row['klasa_id']]['klasa'] = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
                                                }

                                                $querylendeve = "SELECT * FROM lenda";
                                                $result_lendeve = queryMysql($querylendeve);
                                                $lendet = array();
                                                while ($row = $result_lendeve->fetch_assoc()) 
                                                {
                                                    $lendet[$row['lenda_id']]['lenda_id'] = $row['lenda_id'];
                                                    $lendet[$row['lenda_id']]['lenda'] = $row['emertimi'];
                                                }


                                                foreach ($_SESSION['klase_lende'] as $klase_lende_id => $kl_info) 
                                                {
                                                    ?>
                                                    <option value="<?= $klase_lende_id ?>"><?= $klaset[$kl_info['id_klase']]['klasa']
                                                        . ' ' . $lendet[$kl_info['lenda_id']]['lenda'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <br>

                                        <div class="row">
                                            <label for="lloji_selector"><b>Zgjidh cfare do te besh?</b></label>
                                            <select name="lloji_selector" id="lloji_selector">
                                                <option></option>
                                                <option value="note">Vleresim</option>
                                                <option value="mungese">Prezence</option>
                                            </select>
                                        </div>
                                        <input type="submit" value="Perzgjidh" id="kerkesat" name="kerkesat"
                                            class="btn btn-outline-dark">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

    <script>
        $("#piktura").hover(function()
        {
            $(this).css("background-color", "#44999c");
        });
    </script>

</body>
</html>
