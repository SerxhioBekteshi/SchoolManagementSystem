<?php ?>
<!DOCTYPE html>
<?php
    // funksioni require_once kopjon permbajtjen e 'header.php' dhe e shton vetem njehere ne file-in 'ndrysho.P.php' dhe 'function.php'
    require_once 'header.php';
    //kontrollojme nese roli i user eshte pedagog
    if ($_SESSION['roli'] != 'pedagog')
        exit;
    $message=" ";
    require_once 'functions.php';
    if(isset($_POST['submit_change']))
    {  //post merr paswordin nese i behet submit formes
        $oldPass=passwordify($_POST['oldPass']) ;
        $newPass=$_POST['newPass'];
        $newPassConfirm=$_POST['newPassConfirm'];
        if($oldPass!=$_SESSION['pass'])
        {
            $message=" Passwordi i shenjuar si aktuali nuk eshte aktuali ";
        }
        else
        {
            if($newPass!=$newPassConfirm)
            {
                $message=" Ju lutem sigurohuni qe te dy fjalekalimet te perputhen. ";
            }
            else
            {
                $passi=passwordify($newPass);  // passwordify enkriptimi dhe krahasimi me passin e shkruar ne databaze
                $useri=$_SESSION['user'];
                $update_sql="UPDATE `user` SET password='$passi' WHERE user_email='$useri'";
                $resultiii=queryMysql($update_sql);
                if(!$resultiii)
                {
                    $message=" Fjalekalimi eshte gabim. ";
                }
            }
        }
    }
    $randstr = substr(md5(rand()), 0, 7);
?>
 <html>
 <head>
     <meta charset="utf-8">
     <title>PEDAGOG</title>
     <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
     <link rel="stylesheet" type="text/javascript" href="student.js">
     
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
     <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
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
    </header>

     <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
         <a class="navbar-brand text-white" href="shfaqInfo.php"><strong><span style="color:#D31A38">SMA</span></strong></a>

         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto"></ul>
             <div>
                 <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out </a>
             </div>
         </div>
     </nav>

    <!------------------------------------------------SIDEBAR-i------------------------------------------------------>
    <div class="sidebar">
        <div class="profile_info">
            <a href="prof_header.php" id = "piktura" style= "text-align:center">
                <img src="profesor.png" class="std"> </a> 
                    <h5><i>Pedagog</i></h5>
        </div>
        <!---------------------------Veprime qe kryen pedagogu| ndryshimi pass, vleresimi studentit-------------------------------------->
        <a href="ndryshoP.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="vleresimi.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Veprime</span></a>
        <a href="shfaqInfo.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shfaq notat dhe mungesat</span></a>

    </div>
 

 <!-------------------------------------------------CONTENT--------------------------------------------------->

    <div class="content">
        <div class="container">
            <div class="content" style="margin:auto;width: 60%">
                <section class="mb-7 text-left">
                    <br><br> <br> <br>
                    <h4 class="menaxho" > <b>CHANGE PASSWORD</b></h4>
                    <br>
                        <div class="d-flex shadow" style="height:800px width:900px; background: orange">
                            <div  class="container-fluid my-auto">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <br>

                                        <form action="ndryshoP.php" method="post">
                                            <div style="position: relative; left: 30%;">
                                                <div class="md-form md-outline"  >
                                                    <label data-error="wrong" data-success="right" for="oldPass"><b>Old Password</b></label>
                                                    <br>
                                                    <input type="password" id="oldPass" name="oldPass" class="form-control" required="">
                                                    <br>
                                                </div>

                                                <div class="md-form md-outline">
                                                    <label data-error="wrong" data-success="right" for="newPass"><b>New Password</b></label> <br>
                                                    <input type="password" id="newPass" name="newPass" class="form-control" required=""><br>

                                                </div>

                                                <div class="md-form md-outline">
                                                    <label data-error="wrong" data-success="right" for="newPassConfirm"><b>Confirm New Password</b></label>
                                                    <br>
                                                    <input type="password" id="newPassConfirm" name="newPassConfirm" class="form-control" required="">
                                                </div><br>

                                            </div>
                                            <p  class="text-center" style="color: red"><b> <?php echo $message ;   ?> </b> </p>
                                            <div class="md-form md-outline">
                                                <button type="submit" name="submit_change" class="btn btn-outline-dark" style="position: relative; left: 11%;">Ndrysho Fjalekalimin</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#piktura").hover(function ()
        {
            $(this).css("background-color", "#44999c");
        });
    </script>
    
 </body>
 </html>