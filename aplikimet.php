<!DOCTYPE html>
<?php
require_once 'header.php';
if ($_SESSION['roli'] != 'student')
    exit;
require_once 'functions.php';
$idmesquery = "SELECT student_id, id_klase from student where student_email='{$_SESSION['user']}'";
$mes_id_res = queryMysql($idmesquery);
$row = $mes_id_res->fetch_assoc();
$student_id=$_SESSION['student_id'] = $row['student_id'];
$student_klase_id=$_SESSION['student_klase_id']=$row['id_klase'];

if(isset($_POST['listeNotash'])){
    $lloji='liste notash';
    $kerkesa_query="INSERT INTO kerkese_vertetimi (student_id,id_klase,lloji) values ('$student_id','$student_klase_id','$lloji')";
    $kerkesa_result = queryMysql($kerkesa_query);
    if(!$kerkesa_result){
        echo 'Gabim ne kerkese liste notash';
    }
}if(isset($_POST['vertetimStudenti'])){
    $lloji='vertetim studenti';
    $kerkesa_query="INSERT INTO kerkese_vertetimi (student_id,student_klase_id,lloji) values ('$student_id','$student_klase_id','$lloji')";
    $kerkesa_result = queryMysql($kerkesa_query);
    if(!$kerkesa_result){
        echo 'Gabim ne kerkese vertetimi';
    }
}
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Aplikime ne Sekretari</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>

<input type="checkbox" id="check" name="">
<!-----------------------HEADER------------------------------>
<!-------------------------HEADER--------------------------------------->
<header>
    <label for="check">
        <i class="fa fa-bars" id="sidebar_btn"></i>
    </label>
    <div class="left_area">
        <h4> F<span>TI </span></h4>
    </div>
    <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
        <a class="navbar-brand text-white" href="stud_header.php"><strong>F<span style="color:#D31A38">TI</span></strong></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
                aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>
            <div>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out </a>
            </div>
        </div>
    </nav>
</header>

<!-------------------------SIDEBAR-i--------------------->
<div class="sidebar" >
    <div class="profile_info">
        <img src="student.png" class="std">
        <h5><i>Student</i></h5>
    </div>
    <a href="ndryshoPS.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
    <a href="shihnotat.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shih notat</span></a>
    <a href="aplikimet.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Apliko</span></a>

</div>
<!------------------------------CONTENT------------------------------->
<div class="content" style="margin:auto;width: 60%">
    <div class="permbajtja">
        <div align="center">
            <br><br><br>
            <section id="ln" >
                <br><br> <br> <br>
                <div class="d-flex shadow" style="height:800px width:900px; background: lightgrey">
                    <div  class="container-fluid my-auto">
                        <div class="row">
                            <div class="col-lg-10">
                                <br>
                                <form method="post" action="aplikimet.php">
                                    <table align="center" cellpadding = "10">
                                        <tr>
                                            <td>
                                            <th><p class="aplikim"> Aplikim Per Vertetim Studenti</p>
                                            </th>
                                            </td>
                                            <td colspan="2" align="center">
                                                <input class="bttn" name="vertetimStudenti" type="submit" value="Apliko">
                                            </td>
                                            <td>
                                            <th><p class="aplikim"> Aplikim Per Liste Notash </p></th>
                                            </td>
                                            <td colspan="2" align="center">
                                                <input class="bttn" name="listeNotash" type="submit" value="Apliko"  class="btn btn-outline-dark mb-3">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
</body>
</html>