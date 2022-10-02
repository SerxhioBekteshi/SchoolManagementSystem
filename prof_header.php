<!DOCTYPE html>
<?php
    require_once 'header.php'; //require headerin
    if ($_SESSION['roli'] != 'pedagog') //kontrollojm nqs roli eshte pdagog 
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
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/javascript" href="student.js">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="check" name="">
    <label for="check">
        <i class="fa fa-bars" id="sidebar_btn"></i>
    </label>

    <header>
        <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
            <a class="navbar-brand text-white" href="prof_header.php"><strong><span style="color:#D31A38">SMA</span></strong></a>
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
            <a href="prof_header.php" id = "piktura" style= "text-align:center">
                <img src="profesor.png" class="std"> </a> 
                    <h5><i>Pedagog</i></h5>
        </div>
        <a href="ndryshoP.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="vleresimi.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Veprime</span></a>
        <a href="shfaqInfo.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shfaq notat dhe mungesat</span></a>
    </div>

    <!-- <div class = "welcome">
        <h1> Mireserdhe <?php echo "" . $_SESSION['user']?> </h1>
        <br>
        <img src="emoji.jpg" alt="" height="300" widht="300">
    </div>  -->

    <script>
        $("#piktura").hover(function ()
        {
            $(this).css("background-color", "#44999c");
        });
    </script>
</body>
</html>