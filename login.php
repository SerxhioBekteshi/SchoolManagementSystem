<html>
<head>
    <title>STUDENT MANAGEMENT SYSTEM </title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="javascript.js">
    <link rel="stylesheet" href="stilimi.css?v=<?php echo time();?>">


</head>
<body>
<?php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['loginButton'])) 
{
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $pass = passwordify($pass);
    if ($user == "" || $pass == "")
        $error = 'Nuk jane futur gjithe te dhenat';
    else 
    {
        $result = queryMysql("SELECT user_email, password FROM `user` WHERE user_email='$user' AND password='$pass'");
        $rowCount = $result->num_rows;
        print($rowCount);
        if ($rowCount == 0) 
        {
            echo "Invalid login attempt";
        } 
        else 
        {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            header("Location: profili.php");
        }
    }
}
?>


<div class="d-flex shadow" style="height:750; background: url(shkolla.jpg) no-repeat; background-size: cover">
    <div  class="container-fluid my-auto">
        <div class="row">
            <div class = "title"> SMA <h2 class="slider"> SYSTEM </h2> </div>
                <div class="col-lg-6">
                    <div class="w-50 mx-auto card shadow-lg" >
                        <div class="card-body">
                            <div class="border rounded-circle mx-auto d-flex" style="width:100px; height:100px; background-color:red" > 
                                <i class="fa fa-user text-light fa-3x m-auto"></i> </div>

                                    <!---------------------------- VALIDIMI I FORMES ---------------------------------->
                                    <form action="login.php?r=$randstr" method="POST" class="" name="myform" onsubmit="return validate()">
                                        <!-- EMAIL -->
                                        <div class="md-form">
                                            <input type="email" name="user" id="user" class="form-control" required="userid">
                                            <label for="inputPrefilledEx">Email</label>
                                        </div>
                                        <!-- PASSWORDI -->
                                        <div class="md-form">
                                            <input type="password" id="pass" class="form-control" required="password" name="pass">
                                            <label for="inputPrefilledEx">Password</label>
                                        </div>
                                        <button class="btn btn-lg btn-dark btn-block" name="loginButton"> Login</button>
                                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="">
    <div class="footer">SCHOOL MANAGEMENT APPLICATION</div>
</footer>


</body>
</html>