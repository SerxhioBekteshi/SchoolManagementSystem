<!DOCTYPE html>
<?php

    require_once 'header.php';
    if ($_SESSION['roli'] != 'student')
        exit;
    require_once 'functions.php';


    $message=" ";
    if(isset($_POST['submit_change'])) //nqs shtypet butoni submit change nga forma per ndryshimin e passwordit
    {
        $oldPass=passwordify($_POST['oldPass']) ; //ruajme variablat per pass e vjeter te riun dhe konfirmit e te rirut 
        $newPass=$_POST['newPass'];
        $newPassConfirm=$_POST['newPassConfirm'];
        if($oldPass!=$_SESSION['pass']) //nqs pass i vjeter sperputhet 
        {
            $message=" Fjalekalimi nuk perputhet me aktualin ";
        }
        else
        {
            if($newPass!=$newPassConfirm) //nqs dy pass e rinj sperputhen 
            {
                $message=" Ju lutem sigurohuni qe te dy fjalekalimet te perputhen. ";
            }
            else
            { //nqs perputhen e updatojme ne databaze
                $passi=passwordify($newPass);
                $useri=$_SESSION['user'];
                $update_sql="UPDATE `user` SET password='$passi' WHERE user_email='$useri'";
                $resultiii=queryMysql($update_sql);
                if(!$resultiii)
                {
                    $message=" Fjalekalimi juaj eshte gabim ";
                }
                else 
                    $message=" Fjalekalimi juaj u nderrua ";
            }
        }
    }
    $randstr = substr(md5(rand()), 0, 7);
?>
<!DOCTYPE html>
<html>
<!------------Links -------------------------------------------------------------->
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="student.js">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
</head>
<body>
    <input type="checkbox" id="check" name="">

    <!-------------------------HEADER--------------------------------------->
    <header>
        <label for="check">
            <i class="fa fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <h4> SM<span>MA </span></h4>
        </div>
        <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
            <a class="navbar-brand text-white" href="stud_header.php"><strong>S<span style="color:#D31A38">MA</span></strong></a>
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
        <a href="stud_header.php" id = "piktura" style= "text-align:center"><img src="studenti.png" class="std"> </a> 
            <h5><i>Student</i></h5>
        </div>
        <a href="ndryshoPS.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
        <a href="shihnotat.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shih notat</span></a>
        <!-- <a href="aplikimet.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Apliko</span></a> -->
    </div>



    <!-----------------------------------------Permbajtja--------------------------------------------->
    <div class="content">
        <div class="container">
            <div class="content" style="margin:auto;width: 60%">
                <section class="mb-7 text-left">
                    <br><br> <br> <br>
                    <h4 class="menaxho"> CHANGE PASSWORD</h4>
                    <br>
                        <div class="d-flex shadow" style="height:800px width:700px; background: orange;">
                            <div  class="container-fluid my-auto">
                                <div class="row">
                                    <div class="col-lg-10">
                                        <br>
                                        <form action="ndryshoPS.php" method="post">
                                            <div style="position: relative; left: 30%;">

                                                <!-- old password -->
                                                <div class="md-form md-outline">
                                                    <label data-error="wrong" data-success="right" for="oldPass"><b>Old Password</b></label>
                                                    <br>
                                                    <input type="password" id="oldPass" name="oldPass" class="form-control" required="">
                                                    <br>
                                                </div>

                                                <!-- new password -->
                                                <div class="md-form md-outline">
                                                    <label data-error="wrong" data-success="right" for="newPass"><b>New Password</b></label>
                                                    <br>
                                                    <input type="password" id="newPass" name="newPass" class="form-control" required="">
                                                    <br>
                                                </div>

                                                <!-- confirm new password -->
                                                <div class="md-form md-outline">
                                                    <label data-error="wrong" data-success="right" for="newPassConfirm"><b>Confirm New Password</b> </label>
                                                    <br>
                                                    <input type="password" id="newPassConfirm" name="newPassConfirm" class="form-control" required="">
                                                    <br>
                                                </div>
                                                <br>

                                            </div>

                                            <p  class="text-center" style="color: red"><b> <?php echo $message;?> </b> </p>

                                            <!-- BUTTON CHANGE PASSWORD -->
                                            <div class="md-form md-outline">
                                                <button type="submit" name="submit_change" class="btn btn-outline-dark mb-3" 
                                                style="position: relative; left: 11%;">Change password</button>
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

    <script>
        $("#piktura").hover(function ()
        {
            console.log("FEFEF");
            $(this).css("background-color", "#44999c");
        });
    </script>

</body>
</html>