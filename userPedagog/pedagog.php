<?php require_once 'functions.php';
include_once 'header.php';
include_once 'sek_header.php';

$showTableQuery = "SELECT * FROM mesues INNER JOIN user ON user.user_email = mesues.email WHERE 1=1 ";
$resultStudent = queryMysql($showTableQuery);
$pedagog = array();
while ($row = $resultStudent->fetch_assoc()) {
    $pedagog[$row['email']]['email'] = $row['email'];
    $pedagog[$row['email']]['mesues_id'] = $row['mesues_id'];
    $pedagog[$row['email']]['emri'] = $row['emri'];
    $pedagog[$row['email']]['mbiemri'] = $row['mbiemri'];
    $pedagog[$row['email']]['cel'] = $row['cel'];
    $pedagog[$row['email']]['adresa'] = $row['adresa'];
    $pedagog[$row['email']]['gjinia'] = $row['gjinia'];
    $pedagog[$row['email']]['roli'] = $row['roli'];
    $pedagog[$row['email']]['titulli'] = $row['titulli'];
}

if (isset($_POST['submitForma'])) {
    $error = "";

    $emri = sanitizeString($_POST['emri']);
    $mbiemri = sanitizeString($_POST['mbiemri']);
    $email = sanitizeString($_POST['email']);
    $cel = sanitizeString($_POST['cel']);
    $adresa = sanitizeString($_POST['adresa']);
    $gjinia = $_POST['gjinia'];
    $roli_mesues = $_POST['roli'];
    $titulli = $_POST['titulli'];
    $roli_user = 'pedagog';
    $pass = generateRandomString();
    $password = passwordify($pass);

    if (($emri == "") && ($mbiemri == "") && ($email == "") && ($roli_user == "") && ($roli_mesues == "") && ($cel == "") && ($gjinia == "") && ($password == "") && ($titulli == ""))
        $error = 'Nuk jane futur gjithe te dhenat<br><br>';
    else {
        $result = queryMysql("SELECT * FROM user WHERE user_email='$email'");
        $rowCount = $result->num_rows;
        $insertUserQuery = "INSERT INTO user (user_email,user_password,user_role,user_emri,user_mbiemri) VALUES('$email', '$password','$roli_user','$emri','$mbiemri')";
        $insertStudentQuery = "INSERT INTO mesues (emri, mbiemri,roli,gjinia,titulli,email, adresa, cel) VALUES('$emri','$mbiemri','$roli_mesues','$gjinia','$titulli','$email','$adresa','$cel')";
        if ($rowCount != 0)
            $error = 'Eshte nje perdorues i regjistruar me kete email.<br><br>';
        else {
            if (queryMysql($insertUserQuery) && queryMysql($insertStudentQuery)) {
                echo("U ruajt Pedagogu");
                mail("$email", 'Regjistrimi', "I nderuar $emri $mbiemri, passwordi juaj eshte: $pass!", 'Sekretaria FTI');
            } else {
                echo "Gabim:$error";
            }
        }
    }

}
if (isset($_POST['edit_pedagog'])) {
    $emri = sanitizeString($_POST['emri_modal']);
    $email_old = sanitizeString($_POST['email_id_modal']);
    $mbiemri = sanitizeString($_POST['mbiemri_modal']);
    $adresa = sanitizeString($_POST['adresa_modal']);
    $cel = sanitizeString($_POST['cel_modal']);
    $titulli = sanitizeString($_POST['titulli_modal']);
    $roli = sanitizeString($_POST['roli_modal']);

    $update_user_query = "UPDATE user SET user_emri='$emri', user_mbiemri='$mbiemri' WHERE user_email='$email_old'";
    $update_pedagog_query = "UPDATE mesues SET emri='$emri', mbiemri='$mbiemri', roli='$roli', titulli='$titulli',adresa='$adresa',cel='$cel' WHERE email='$email_old'";

    if (queryMysql($update_user_query) && queryMysql($update_pedagog_query)) {
        echo("U ruajt Pedagogu");
    } else {
        echo "Gabim:$error";
    }
}
if (isset($_POST['butoni_fshirjes'])) {
    $email = $_POST['fshij_student'];
    echo $email;
    $fshijQuery = "DELETE FROM mesues WHERE email ='$email'";
    $fshijQuery2 = "DELETE FROM user WHERE user_email ='$email'";
    $result = queryMysql($fshijQuery);
    $result2 = queryMysql($fshijQuery2);
}
?>
<head>

    <nav class="navbar navbar-expand-sm bg-light navbar-light navbar-fixed-top">
        <a class="navbar-brand" href="sek_header.php">FTI</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>

            <form class="form-inline my-2 my-lg-0" method="post" action="pedagog.php">
                <div>
                    <input class="form-control mr-sm-4" type="search" name="searchField" placeholder="Search"
                           aria-label="Search">
                </div>
                <div>
                    <button class="btn btn-outline-success my-4 my-sm-0" name="submitSearch" type="submit">Search
                    </button>
                </div>

            </form>
            <a href="logout.php">
                <button class="btn btn-primary my-0 my-sm-0">Log out</button>
            </a>
        </div>
    </nav>


    <title>Pedagog</title>
    <link rel="stylesheet" type="text/css" href="sekretaria.css">
    <script type="text/javascript" src="student.js"></script>
</head>

<nav>
    <div class="sidebar">
        <a href="sek_header.php">Sekretaria Mesimore</a>
        <a href="student.php">Student</a>
        <a class="active" href="pedagog.php">Pedagog</a>
        <a href="lendet.php">Lendet</a>
        <a href="grupi.php">Klasa</a>
        <a href="vertetime.php">Vertetime</a>
    </div>
</nav>
<div class="content">
    <strong><span class="spantxt"> Menaxhimi i Pedagogeve </span></strong>
    <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Regjistro Pedagog
    </button>
    <hr>

    <br>
    <div class="container">
        <div class="row">

            <div class="border border-success col-sm-12">
                <h3 class="text-light">Filter kerkimi</h3>
                <form action="pedagog.php" method="POST" name="myForm">
                    <div class="form-row align-items-center">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="emriFilter"><p class="text-light">Emri</p></label>
                                <input class="form-control" type="text" name="emriFilter" id="emriFilter">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="mbiemriFilter"><p class="text-light">Mbiemri</p></label>
                                <input class="form-control" type="text" name="mbiemriFilter" id="mbiemriFilter">
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="emailFilter"><p class="text-light">Email</p></label>
                                <input class="form-control" type="text" name="emailFilter" id="emailFilter">
                            </div>
                        </div>


                    </div>
                    <div class="form-row align-items-center">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="roliFilter"><p class="text-light">Roli</p></label>
                                <select class="form-control" type="text" name="roliFilter" id="roliFilter">
                                    <option></option>
                                    <?php
                                    foreach ($pedagog as $row) {
                                        echo "<option value='" . $row['roli'] . "'>" . $row['roli'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <input type="submit" name="filterKerkimi" class="btn btn-primary" value="Kerko">
                        </div>
                    </div>

                    <br><br>
                </form>

            </div>
            <table align="center" border="1px" id="tabela_1" class="tabela1">
                <tr>
                    <th><b>Emri</b></th>
                    <th><b>Mbiemri</b></th>
                    <th><b>Email</b></th>
                    <th><b>Roli</b></th>
                    <th><b>Titujt</b></th>
                    <th><b>Adresa</b></th>
                    <th><b>Gjinia</b></th>
                    <th><b>Cel</b></th>

                </tr>
                <?php

                if (isset($_POST['submitSearch'])) {
                    $search = sanitizeString($_POST['searchField']);
                    foreach ($pedagog as $row) {
                        if (str_contains(strtolower ($row['emri']),strtolower($search) ) || str_contains(strtolower ($row['mbiemri']),strtolower($search) )||str_contains(strtolower ($row['email']),strtolower($search) ) || str_contains(strtolower ($row['roli']),strtolower($search) ) ) {
                            echo "<tr><td><span id='emri_" . $row['mesues_id'] . "'> " . $row['emri'] . "</span></td>";
                            echo "<td><span id='mbiemri_" . $row['mesues_id'] . "'>" . $row['mbiemri'] . "</span></td>";
                            echo "<td><span id='email_" . $row['mesues_id'] . "'>" . $row['email'] . "</span></td>";
                            echo "<td><span id='roli_" . $row['mesues_id'] . "'>" . $row['roli'] . "</span></td>";
                            echo "<td><span id='titulli_" . $row['mesues_id'] . "'>" . $row['titulli'] . "</span></td>";
                            echo "<td><span id='adresa_" . $row['mesues_id'] . "'>" . $row['adresa'] . "</span></td>";
                            echo "<td><span id='gjinia_" . $row['mesues_id'] . "'>" . $row['gjinia'] . "</span></td>";
                            echo "<td><span id='cel_" . $row['mesues_id'] . "'>" . $row['cel'] . "</span></td>";
                            ?>
                            <td>
                                <button type="button" onClick="updateInput('<?php echo $row['email']; ?>');"
                                        class="btn btn-primary" data-toggle="modal" data-target="#fshij">
                                    Fshij
                                </button>

                            </td>
                            <td><!-- Button trigger modal -->

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal" name=""
                                        onClick="updateInput('<?php echo $row['email']; ?>');fillFields('<?php echo $row['mesues_id']; ?>')">
                                    Edit
                                </button>
                            </td>
                            </tr>

                            <?php

                        }
                    }

                } elseif (isset($_POST['filterKerkimi'])) {
                    $emriFilter = sanitizeString($_POST['emriFilter']);
                    $roliFilter = sanitizeString($_POST['roliFilter']);
                    $mbiemriFilter = sanitizeString($_POST['mbiemriFilter']);
                    $emailFilter = sanitizeString($_POST['emailFilter']);

                    foreach ($pedagog as $row) {
                        if (($row['emri']==$emriFilter ||''==$emriFilter) && ($row['mbiemri']==$mbiemriFilter ||''==$mbiemriFilter)&& ($row['email']==$emailFilter ||''==$emailFilter)&& ($row['roli']==$roliFilter ||''==$roliFilter)) {
                            echo "<tr><td><span id='emri_" . $row['mesues_id'] . "'> " . $row['emri'] . "</span></td>";
                            echo "<td><span id='mbiemri_" . $row['mesues_id'] . "'>" . $row['mbiemri'] . "</span></td>";
                            echo "<td><span id='email_" . $row['mesues_id'] . "'>" . $row['email'] . "</span></td>";
                            echo "<td><span id='roli_" . $row['mesues_id'] . "'>" . $row['roli'] . "</span></td>";
                            echo "<td><span id='titulli_" . $row['mesues_id'] . "'>" . $row['titulli'] . "</span></td>";
                            echo "<td><span id='adresa_" . $row['mesues_id'] . "'>" . $row['adresa'] . "</span></td>";
                            echo "<td><span id='gjinia_" . $row['mesues_id'] . "'>" . $row['gjinia'] . "</span></td>";
                            echo "<td><span id='cel_" . $row['mesues_id'] . "'>" . $row['cel'] . "</span></td>";

                            ?>
                            <td>
                                <button type="button" onClick="updateInput('<?php echo $row['email']; ?>');"
                                        class="btn btn-primary" data-toggle="modal" data-target="#fshij">
                                    Fshij
                                </button>

                            </td>
                            <td><!-- Button trigger modal -->

                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModal" name=""
                                        onClick="updateInput('<?php echo $row['email']; ?>');fillFields('<?php echo $row['mesues_id']; ?>')">
                                    Edit
                                </button>
                            </td>
                            </tr>


                            <?php
                        }

                    }
                } else {

                    foreach ($pedagog as $row) {
                        echo "<tr><td><span id='emri_" . $row['mesues_id'] . "'> " . $row['emri'] . "</span></td>";
                        echo "<td><span id='mbiemri_" . $row['mesues_id'] . "'>" . $row['mbiemri'] . "</span></td>";
                        echo "<td><span id='email_" . $row['mesues_id'] . "'>" . $row['email'] . "</span></td>";
                        echo "<td><span id='roli_" . $row['mesues_id'] . "'>" . $row['roli'] . "</span></td>";
                        echo "<td><span id='titulli_" . $row['mesues_id'] . "'>" . $row['titulli'] . "</span></td>";
                        echo "<td><span id='adresa_" . $row['mesues_id'] . "'>" . $row['adresa'] . "</span></td>";
                        echo "<td><span id='gjinia_" . $row['mesues_id'] . "'>" . $row['gjinia'] . "</span></td>";
                        echo "<td><span id='cel_" . $row['mesues_id'] . "'>" . $row['cel'] . "</span></td>";
                        ?>

                        <td>
                            <button type="button" onClick="updateInput('<?php echo $row['email']; ?>');"
                                    class="btn btn-primary" data-toggle="modal" data-target="#fshij">
                                Fshij
                            </button>

                        </td>
                        <td><!-- Button trigger modal -->

                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModal" name=""
                                    onClick="updateInput('<?php echo $row['email']; ?>');fillFields('<?php echo $row['mesues_id']; ?>')">
                                Edit
                            </button>
                        </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </table>
            <br><br>
        </div>
    </div>
</div>
</div>

<div class="modal" id="fshij" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Po fshini</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    A jeni te sigurte qe doni ta fshini??
                </div>
            </div>
            <div class="modal-footer">
                <form action="pedagog.php" method="post">
                    <input type="hidden" name="fshij_student" id="fshij_student">
                    <input type="submit" name="butoni_fshirjes" value="Fshije" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ndryshoni te
                    dhenat</h5>
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="pedagog.php" method="post">
                    <input type="hidden" name="email_id_modal" id="email_id_modal"/>
                    <div class="form-group">
                        <label for="emri">Emri</label>
                        <input type="text" class="form-control" id="emri_modal"
                               name="emri_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="mbiemri">Mbiemri</label>
                        <input type="text" class="form-control" id="mbiemri_modal"
                               name="mbiemri_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="adresa_modal">Adresa</label>
                        <input type="text" class="form-control" id="adresa_modal"
                               name="adresa_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="cel_modal">Celular</label>
                        <input type="text" class="form-control" id="cel_modal"
                               name="cel_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="roli_modal">Roli</label>
                        <input type="text" class="form-control" id="roli_modal"
                               name="roli_modal" value="">
                    </div>
                    <div class="form-group">
                        <label for="titulli_modal">Titulli</label>
                        <input type="text" class="form-control" id="titulli_modal"
                               name="titulli_modal" value="">
                    </div>
            </div>
            <div class="modal-footer">
                <input type="submit" value="Edit" id="edit_pedagog" name="edit_pedagog">
            </div>
            </form>
        </div>

    </div>
</div>

<div id="id01" class="modal">

    <form class="modal-content animate" method="post" action="pedagog.php">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="profesor.png" alt="Avatar" class="avatar">
        </div>

        <!-------------------------REGJISTRIMI PEDAGOGUT--------------------------------->
        <div class="container">
            <h3 id="regjistrimi">REGJISTRIMI I PEDAGOGUT</h3>
            <table align="center" cellpadding="10">

                <!----- First Name ---------------------------------------------------------->
                <tr>
                    <td>Emri*</td>
                    <td><input type="text" name="emri" id="emri" maxlength="30" required/>
                    </td>
                </tr>


                <!----- Last Name ---------------------------------------------------------->
                <tr>
                    <td>Mbiemri*</td>
                    <td><input type="text" name="mbiemri" id="mbiemri" maxlength="30" required/>
                    </td>
                </tr>


                <!----- Email Id ------------------------------------------------->
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="email" name="email" id="email" maxlength="30" requiered/>
                    </td>
                </tr>
                <tr>
                    <td>Adresa</td>
                    <td>
                        <input type="text" name="adresa" id="adresa" maxlength="30" requiered/>
                    </td>
                </tr>


                <!----- Mobile Number ---------------------------------------------------------->
                <tr>
                    <td>Nr. Telefonit/ Cel.</td>
                    <td>
                        <input type="text" name="cel" id="cel" maxlength="10" placeholder="06#########"/>

                    </td>
                </tr>

                <!----- Gender -------------------------------------------------------------------->
                <tr>
                    <td>Gjinia</td>
                    <td> Mashkull <input type="radio" name="gjinia" value="M"/>
                        Femer <input type="radio" name="gjinia" value="F"/>
                    </td>
                </tr>
                <!----- Roli---------------------------------------------------------->
                <tr>
                    <td>Roli</td>
                    <td><input type="text" name="roli" id="roli" maxlength="20" required/>
                    </td>
                </tr>
                <!----- Titulli---------------------------------------------------------->
                <tr>
                    <td>Titulli</td>
                    <td><input type="text" name="titulli" maxlength="15" required/>
                    </td>
                </tr>


                <!---------------------------Submit/Reset----------------------------------->
                <tr>
                    <td colspan="2" align="center">
                        <input class="btn" type="submit" name='submitForma' value="Submit">
                        <input class="btn" type="reset" value="Reset">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button type="bt" onclick="document.getElementById('id01').style.display='none'"
                                class="cancelbtn">Cancel
                        </button>
                    </td>
                </tr>

            </table>
        </div>
    </form>

</div>

<script>
    function updateInput(id) {
        id = String(id);
        document.getElementById("fshij_student").value = id;
        document.getElementById("email_id_modal").value = id;

    }

    function fillFields(id) {
        var emri = $("#emri_" + id).text();
        var mbiemri = $("#mbiemri_" + id).text();
        console.log(emri + ' ' + mbiemri);
        var cel = $("#cel_" + id).text();
        var adresa = $("#adresa_" + id).text();
        var roli = $("#roli_" + id).text();
        var titulli = $("#titulli_" + id).text();

        $("#emri_modal").val(emri);
        $("#mbiemri_modal").val(mbiemri);
        console.log(mbiemri);
        $("#adresa_modal").val(adresa);
        $("#roli_modal").val(roli);
        $("#cel_modal").val(cel);
        $("#titulli_modal").val(titulli);


    }
</script>
</body>
</html>