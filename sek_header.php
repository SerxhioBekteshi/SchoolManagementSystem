<?php // Example 02: header.php
    require_once 'header.php';
    if ($_SESSION['roli'] != 'sekretar' && $_SESSION['roli'] != 'admin')
        exit;

    require_once 'functions.php';
    $randstr = substr(md5(rand()), 0, 7);
?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>User Student</title>
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time(); ?>">

    </head>

<body>
    <style type="text/css">
        .navbar .kerkimi_navbar
        {
            position: absolute; 
            left: 250px;
        }

        #check:checked~.navbar .kerkimi_navbar
        {
            position: absolute; 
            left: 135px;
        }
    </style>
    <input type="checkbox" id="check" name=""> 
        <label for="check">
            <i class="fa fa-bars" id="sidebar_btn"></i>
        </label>

    <header>    
    <!----------------------- NAVBAR--------------->    
        <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
            <a class="navbar-brand text-white" href="sek_header.php"><strong><span style="color:#D31A38">SMA</span></strong></a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto"></ul>                
                        <form class="kerkimi_navbar form-inline float-left my-2 my-lg-0" method="post" action="<?=full_url(); ?>">
                            <div>
                                <input class="form-control mr-sm-4" type="search" name="searchField" placeholder="Search" aria-label="Search">
                            </div>
                            <div>
                                <button class="btn btn-outline-secondary my-6 my-sm-0 mr-sm-3" name="submitSearch" id="SearchButton" type="submit">Search</button>
                            </div>
                        </form>  
                    <div>
                        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out </a>
                    </div>
            </nav>
    </header>        

    <div class="sidebar">
        <div class="profile_info">
            <a href="sek_header.php" id = "piktura" style= "text-align:center">
                <img src="ikone.png" class="std"></a> 
                    <h5><i>SEKRETAR</i></h5>
        </div>

        <a href="student.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Menaxho Student</span></a>
        <a href="pedagog.php"><i class="fa fa-university" aria-hidden="true"></i><span>Menaxho Pedagog</span></a>
        <a href="lendet.php"><i class="fa fa-book" aria-hidden="true"></i><span>Menaxho Lende</span></a>
        <a href="grupi.php"><i class="fa fa-users" aria-hidden="true"></i><span>Menaxho Klasa</span></a>
        
        <?php if ($_SESSION['roli'] == 'admin') 
        { ?>
            <a href="shto_sekretare.php"><i class="fa fa-users" aria-hidden="true"></i><span>Shto sekretare</span></a>
        <?php
        }?>
    </div>
<!-- 
    <div class = "welcome">
        <h1> Mireseerdhe <?php echo "" . $_SESSION['roli']?> </h1>
        <br>
        <img src="emoji.jpg" alt="" height="300" widht="300">
    </div> -->

    <script>
        $("#piktura").hover(function ()
        {
            $(this).css("background-color", "#44999c");
        });
    </script>
</body>
</html>

