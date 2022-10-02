<!DOCTYPE html>
<?php
    require_once 'header.php';
    if ($_SESSION['roli'] != 'student')
        exit;
    require_once 'functions.php';
    //print_array($_SESSION);exit;

    $randstr = substr(md5(rand()), 0, 7);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <!-- <link rel="stylesheet" type="text/css" href="student.js"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <input type="checkbox" id="check" name="">
    <!-------------------------HEADER--------------------------------------->
    <header>
        <label for="check">
            <i class="fa fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <h4> S<span>MA </span></h4>
        </div>
        <div class="right_area">
            <a href="logout.php" class="logout_btn">Logout </a>
        </div>
    </header>
    
    <header>
        <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
            <a class="navbar-brand text-white" href="stud_header.php"><strong>S<span style="color:#D31A38">MA</span></strong></a>
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
        <a href="stud_header.php" id = "piktura" style= "text-align:center"><img src="studenti.png" class="std"> </a> 
            <h5><i>Student</i></h5>
        </div>
        <a href="ndryshoPS.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="shihnotat.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shih notat</span></a>
        <!-- <a href="aplikimet.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Apliko</span></a> -->
    </div>

    <div class = "welcome">
        <h1> Mireserdhe <?php echo "" . $_SESSION['user']?> </h1>
        <br>
        <img src="emoji.jpg" alt="" height="300" widht="300">
    </div>

    <script>
        $("#piktura").hover(function ()
        {
            console.log("FEFEF");
            $(this).css("background-color", "#44999c");
        });
    </script>
</body>
</html>