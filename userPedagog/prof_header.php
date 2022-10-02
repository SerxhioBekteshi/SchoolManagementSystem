<!DOCTYPE html>
<?php
require_once 'header.php';
if ($_SESSION['roli'] != 'pedagog')
    exit;
require_once 'functions.php';
//print_array($tedhenat);exit;

$randstr = substr(md5(rand()), 0, 7);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css">
    <link rel="stylesheet" type="text/css" href="student.js">
</head>
<body>
<!-------------------------HEADER--------------------------------------->
<input type="checkbox" id="check" name=""> 
        <label for="check">
            <i class="fa fa-bars" id="sidebar_btn"></i>
        </label>

<header>

<nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
  <a class="navbar-brand text-white" href="shfaqInfo.php"><strong>F<span style="color:#D31A38">TI</span></strong></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-333"
    aria-controls="navbarSupportedContent-333" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>                
          <div>
             <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out </a>
          </div>
</nav>      
</header>

<!-------------------------SIDEBAR-i--------------------->
<div class="sidebar" >
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

</body>
</html>