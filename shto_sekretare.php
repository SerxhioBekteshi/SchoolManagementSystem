<!DOCTYPE html>
<?php
    //bejme inkludet e nevojshme 
    include_once 'header.php';
    include_once 'sek_header.php';

    //nqs nga forma shtypet butoni shto sekretar 
    if (isset($_POST['ShtoSekretare'])) 
    {
        //variablat e nevojshme per te shtuar sekretar i ruajme 
        $nohash_password = generateRandomString(6);
        $user_role = 'sekretar';
        $user_emri = $_POST['emri'];
        $user_mbiemri = $_POST['mbiemri'];
        $user_email = $_POST['email'];
        $user_password = passwordify($nohash_password);

        //ndertojme query string per insert te tabela e sekretarit 
        $insert_sekretar_query = "INSERT INTO user set user_email='$user_email', password='$user_password', roli='$user_role', emri='$user_emri', mbiemri='$user_mbiemri'";
        $resulti = queryMysql($insert_sekretar_query);
        if (!$resulti) //nqs gabim ne query shfaqet mesazhi 
        {
            echo "KA NDODHUR NJE GABIM";
        } 
        else //nqs query e sakte 
        {
            mail($user_email, "Regjistrim", "I nderuar $user_emri $user_mbiemri, passwordi juaj eshte $nohash_password");
        }
    }

    //admini gjithashtu ka dhe opsionit per te fshire nje sekretar 
    if (isset($_POST['fshij_sekretar'])) //nqs shtypet ky buton nga forma 
    {
        $user_id=$_POST['user_id'];
        $delete_sekretar_query = "DELETE FROM `user` where user_id='$user_id'"; //query per fshirjen 
        $delete = queryMysql($delete_sekretar_query);
        if (!$delete) //nqs jo e sakte shfaqet mesazhi nqs e sakte fshihet dhe nga databaza
        {
            echo "KA NDODHUR NJE GABIM";
        }
    }
?>
<html>
<head>
    <meta charset="utf-8">
    <title>Student</title>

    <script 
        src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous">
    </script>

    <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
        integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
        crossorigin="anonymous">
    </script>
        
    <script 
        src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
        integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
        crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="student.js"></script>
</head>
<body>


<!-------------------------HEADER--------------------------------------->

    <div class="content">
        <div class="container-fluid my-auto">
            <div class="row">
                <div class="col-lg-6">
                    <h3><br></h3>
                    <h4 class="menaxho"> Sekretaria Mësimore</h4>
                </div>
            </div>
        </div>
        <form class="modal-content animate" method="post" action="shto_sekretare.php">

            <!--------------------------------REGJISTRIMI SEKRETARIT --------------------------------->
            <div class="container">
                <h3 id="regjistrimi">Shto sekretare</h3>
                <table align="center" cellpadding="10">

                    <tr>
                        <td>Emri</td>
                        <td><input type="text" name="emri" maxlength="30" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>Mbiemri</td>
                        <td><input type="text" name="mbiemri" maxlength="30" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><input type="email" name="email" maxlength="30" required/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input class="text-center" class="btn btn-outline-dark" type="submit" name="ShtoSekretare"
                                value="Submit">
                            <input class="text-center" class="btn btn-outline-dark" autocomplete="off" type="reset"
                                value="Reset">
                        </td>
                    </tr>


                </table>
            </div>
        </form>
        <table class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th><b>Emri</b></th>
                <th><b>Mbiemri</b></th>
                <th><b>Email</b></th>
                <th><b>Fshij</b></th>
            </tr>
            </thead>
            <tbody style="background-color: white;">
            <?php
            $query_per_tabelen = "SELECT * FROM `user` where roli='sekretar'";
            $resulti_per_tabelen = queryMysql($query_per_tabelen);

            if (!$resulti_per_tabelen) 
            {
                echo "Failed";
            } 
            else 
            {
                while ($row = $resulti_per_tabelen->fetch_assoc()) 
                {
                    ?>
                    <tr>
                        <td><?= $row['emri'] ?></td>
                        <td><?= $row['mbiemri'] ?></td>
                        <td><?= $row['user_email'] ?></td>
                        <td>
                            <form method="post" action="shto_sekretare.php">
                                <input type="hidden" name="user_id" value="<?= $row['user_id'] ?>">
                                <input class="btn btn-primary" type="submit" name="fshij_sekretar" value="Fshij">
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous">
    </script>

    <script 
        src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous">
    </script>

    <script 
        src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">


</body>
</html>