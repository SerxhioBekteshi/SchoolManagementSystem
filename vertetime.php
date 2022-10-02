<!DOCTYPE html>
    <?php   require_once 'functions.php';
    include_once 'sek_header.php';

    ?>
<html>
<head>
    <meta charset="utf-8">
    <title>Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body  style=" background-color:#99A3A4;">
<!-------------------------HEADER--------------------------------------->    
    <header>        

<nav class="navbar navbar-expand-sm navbar-light navbar-fixed-top" style="background-color: #1c2833; position:fixed;">
        <a class="navbar-brand text-white" href="sek_header.php"><strong>F<span style="color:#1DC4E7">TI</span></strong></a>
    
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>                
        </form>
        <a href="logout.php">
            <button id="logout" class="btn btn-primary my-6 my-sm-0 mx-sm-0">Log out</button>
        </a>
    </div>
</nav></header>
    
     <div class="content content-dark">
        <div class="container mt-5">
                       <form action="krijopdf.php" method="post" class="offset-md-3 col-md-6">
                        <br><h1><b>Kerko vertetim</b></h1>
                        <span>Ploteso te dhenat per vertetimin</span>
                      
                      <div class="row mb-2 mt-3" >
                             <div class="col-md-6">
                          <input type="text" name="emri" placeholder="Emri" class="form-control" style="width: 100%" required></div>
                             <div class="col-md-6">
                          <input type="text" name="mbiemri" placeholder="Mbiemri" class="form-control" style="width: 100%" required></div>
                      </div>
                       
                       
                       <div class="mb-2">
                       <input type="email" name="email" placeholder="Email" class="form-control" required></div>
                       
                       <div class="mb-2">
                       <input type="tel" name="nr" placeholder="Numri" class="form-control" required></div>

                       <div class="mb-2">
                       <textarea name="pershkrim" placeholder="Shkruaj..." class="form-control"></textarea>
                       </div>

                       <button type="submit" class="btn btn-outline-dark">Konfirmo</button>
                    </form>
                
</div>
    
        
        
    </div>

  </body>
  </html>
  

 <?php   include 'footer.php' ?>
