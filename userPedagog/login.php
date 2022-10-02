<head>
        <title>SCHOOL MANAGMENT SYSTEM | user admin</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.0/css/mdb.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="javascript.js">
    <link rel="stylesheet" type="text/css" href="style.css">


</head>
<?php // Example 07: login.php
require_once 'header.php';
$error = $user = $pass = "";

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);
    $pass = passwordify($pass);
    if ($user == "" || $pass == "")
        $error = 'Nuk jane futur gjithe te dhenat';
    else {
        $result = queryMysql("SELECT user_email, user_password FROM user WHERE user_email='$user' AND user_password='$pass'");
        $rowCount = $result->num_rows;
        if ($rowCount == 0) {
            echo "Invalid login attempt";
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            die("<div class='center'>Sapo jeni futu nr faqe. Ju lutem
             <a data-transition='slide'
               href='profili.php?view=$user&r=$randstr'>klikoni ketu</a>
               te vazhdoni.</div></div></body></html>");
        }
    }
}
?>

<div class="d-flex shadow" style="height:600px;
    background: linear-gradient(-45deg,#303030 50%,transparent 50%);">
    <div  class="container-fluid my-auto">
      <div class="row">  
        <div class="col-lg-6">
         <h1 class="display-3 "><b> Universiteti Politeknik i Tiranës</b> </h1>
         <p class="fti">Sekretaria Mësimore | FTI </p>
        </div>
        <div class="col-lg-6">
           <div class="w-50 mx-auto card shadow-lg" >
             <div class="card-body">
              <div class="border rounded-circle mx-auto d-flex" style="width:100px;height:100px" > <i class="fa fa-user text-light fa-3x m-auto"></i></div>

        <!---------------------------- Forma e Validuar ---------------------------------->     
                <form action="login.php?r=$randstr" method="POST" class="" name="myform" onsubmit="return validate()">
                   <!-- Material input -->
                   <div class="md-form">
                     <input type="email" name="user" id="email" class="form-control" required="userid">
                     <label for="inputPrefilledEx">Email</label>
                    </div>
                     <!-- Material input -->
                   <div class="md-form">
                     <input type="password" id="pass" class="form-control" required="password" name="pass">
                     <label for="inputPrefilledEx">Password</label>
                    </div>
                    <button class="btn btn-lg btn-dark btn-block"> Login</button>
                </form>   
 
    <!---------------------------- Forma e Validuar ---------------------------------->  
 
             </div>
           </div>
        </div>      
      </div>
    </div> 
  </div> 

<!-- Footer -->
<footer class="">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2021 Copyright:
    <a href="https://mdbootstrap.com/"> UPT| FTI</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->




</body>
</html>