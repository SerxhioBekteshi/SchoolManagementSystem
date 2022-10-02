 <?php ?>
<!DOCTYPE html>
<?php
require_once 'header.php';
if ($_SESSION['roli'] != 'pedagog')
    exit;
require_once 'functions.php';
if(isset($_POST['submit_change'])){
    $oldPass=passwordify($_POST['oldPass']) ;
    $newPass=$_POST['newPass'];
    $newPassConfirm=$_POST['newPassConfirm'];
    if($oldPass!=$_SESSION['pass']){
        echo 'GABIMsafas';
    }else{
        if($newPass!=$newPassConfirm){
            echo 'GABIMaaa';

        }
        else{
            $passi=passwordify($newPass);
            $useri=$_SESSION['user'];
            $update_sql="UPDATE user SET user_password='$passi' WHERE user_email='$useri'";
            $resultiii=queryMysql($update_sql);
            if(!$resultiii){
                echo "gabim prap";
            }
        }
    }
}
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

</div>
<div class="content">
    <div class="container">
        <div class="content" style="margin:auto;width: 40%">
            <section class="mb-5 text-left">

                <p>Set a new password</p>

                <form action="ndryshoP.php" method="post">

                    <div class="md-form md-outline">
                        <input type="password" id="oldPass" name="oldPass" class="form-control">
                        <label data-error="wrong" data-success="right" for="oldPass">Fjalekalimi i vjeter</label>
                    </div>

                    <div class="md-form md-outline">
                        <input type="password" id="newPass" name="newPass" class="form-control">
                        <label data-error="wrong" data-success="right" for="newPass">Fjalekalimi i ri</label>
                    </div>

                    <div class="md-form md-outline">
                        <input type="password" id="newPassConfirm" name="newPassConfirm" class="form-control">
                        <label data-error="wrong" data-success="right" for="newPassConfirm">Confirm password</label>
                    </div><br>
                    <div class="md-form md-outline">
                        <button type="submit" name="submit_change" class="btn btn-primary mb-4" style="display: block;">Change password</button>
                    </div>
                </form>

            </section></div>

    </div>
</div>
</body>
</html>