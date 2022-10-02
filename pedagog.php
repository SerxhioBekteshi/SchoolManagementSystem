<?php 
    //inlcude dokumentet qe na duhen
    require_once 'functions.php';
    include_once 'header.php';
    include_once 'sek_header.php';

    //query e pedagogut per ti bere fetch nga databasza 
    $showTableQuery = "SELECT * FROM pedagog INNER JOIN `user` ON `user`.user_email = pedagog.email WHERE 1=1 ";
    $resultStudent = queryMysql($showTableQuery);
    $pedagog = array(); //dhe cdo fetch e ruam ne vektorin pedagog associative
    while ($row = $resultStudent->fetch_assoc()) 
    {
        $pedagog[$row['email']]['pedagog_id'] = $row['pedagog_id'];
        $pedagog[$row['email']]['emri'] = $row['emri'];
        $pedagog[$row['email']]['mbiemri'] = $row['mbiemri'];
        $pedagog[$row['email']]['pozicioni'] = $row['pozicioni'];
        $pedagog[$row['email']]['gjinia'] = $row['gjinia'];
        $pedagog[$row['email']]['titulli'] = $row['titulli'];
        $pedagog[$row['email']]['email'] = $row['email'];
        $pedagog[$row['email']]['adresa'] = $row['adresa'];
        $pedagog[$row['email']]['tel'] = $row['tel'];
    }

    //nqs e forma shtypet butoni me emer submitForma
    if (isset($_POST['submitForma'])) 
    {
        $error = "";
        //ruajme variablat e nevojshme te marr nga forma 
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

        //nqs bosh shfaqim nje mesaazh errori
        if (($emri == "") && ($mbiemri == "") && ($email == "") && ($roli_user == "") && ($roli_mesues == "") && ($cel == "") && ($gjinia == "") && ($password == "") && ($titulli == ""))
            $error = 'Nuk jane futur gjithe te dhenat<br><br>';
        else 
        {
            //shtojme te dhenat ne databazes e tabeles pedagog dhe user nqs cdo query rezulton e sukssesshme 
            $result = queryMysql("SELECT * FROM `user` WHERE user_email='$email'");
            $rowCount = $result->num_rows;
            $insertUserQuery = "INSERT INTO `user` (user_email,password,roli, emri, mbiemri) VALUES('$email', '$password','$roli_user','$emri','$mbiemri')";
            $insertStudentQuery = "INSERT INTO `pedagog` (emri, mbiemri,pozicioni,gjinia,titulli,email, adresa, tel) VALUES('$emri','$mbiemri','$roli_mesues','$gjinia','$titulli','$email','$adresa','$cel')";
            if ($rowCount != 0)
                $error = 'Eshte nje perdorues i regjistruar me kete email.<br><br>';
            else 
            {
                if (queryMysql($insertUserQuery) && queryMysql($insertStudentQuery)) {
                    echo("U ruajt Pedagogu");
                    mail("$email", 'Regjistrimi', "I nderuar $emri $mbiemri, passwordi juaj eshte: $pass!", 'Sekretaria FTI');
                } 
                else 
                {
                    echo "Gabim:$error";
                }
            }
        }
    }

    //buotni edit pedagog nga forma nqs shtypet 
    if (isset($_POST['edit_pedagog'])) 
    {
        $emri = sanitizeString($_POST['emri_modal']);
        $email_old = sanitizeString($_POST['email_id_modal']);
        $mbiemri = sanitizeString($_POST['mbiemri_modal']);
        $adresa = sanitizeString($_POST['adresa_modal']);
        $cel = sanitizeString($_POST['cel_modal']);
        $titulli = sanitizeString($_POST['titulli_modal']);
        $roli = sanitizeString($_POST['roli_modal']);

        //e updatojme nebaze te fushave te plotesuara nga dritarja edit qe shfaqet 
        $update_user_query = "UPDATE `user` SET emri='$emri', mbiemri='$mbiemri' WHERE user_email='$email_old'";
        $update_pedagog_query = "UPDATE `pedagog` SET emri='$emri', mbiemri='$mbiemri', pozicioni='$roli', titulli='$titulli',adresa='$adresa',tel='$cel' WHERE email='$email_old'";

        if (queryMysql($update_user_query) && queryMysql($update_pedagog_query)) 
        {
            echo("U ruajt Pedagogu");
        } 
        else 
        {
            echo "Gabim:$error";
        }
    }

    //e njejta logjike ndiqet dhe per fshirje vetem se kemi query per fshirjen nga databaza 
    if (isset($_POST['butoni_fshirjes'])) 
    {
        $email = $_POST['fshij_student'];
        echo $email;
        $fshijQuery = "DELETE FROM pedagog WHERE email ='$email'";
        $fshijQuery2 = "DELETE FROM user WHERE user_email ='$email'";
        $result = queryMysql($fshijQuery);
        $result2 = queryMysql($fshijQuery2);
    }
?>
<head>
    <title>Pedagog</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="student.js"></script>

    <script>
        function validate() //validimet te njejta si te studentit
        {
            var emriFilter= document.getElementById("emri").value;
            if(emriFilter=="")
            {
                alert(" Ju lutem shkruani emrin");
                return false;
            } 
            else
            {
                var nameRegex = /^[a-zA-Z\-]+$/;
                var x = nameRegex.test(emriFilter)
                if(x)
                {
                }
                else
                {
                    alert(" Gabim ne emer. ");
                    return false;
                }
            }

            var mbiemriFilter=document.getElementById("mbiemri").value;

            if(mbiemriFilter=="")
            {
                alert(" Ju lutem shkruani mbiemrin");
                return false;
            } 
            else 
            {
                var mbiemriRegex = /^[a-zA-Z\-]+$/;
                var y = mbiemriRegex.test(mbiemriFilter)

                if(y)
                {
                }
                else
                {
                    alert(" Gabim ne mbiemer. ");
                    return false;
                }
            }

            var emailFilter=document.getElementById("email").value;
            if(emailFilter=="")
            {
                alert(" Ju lutem shkruani email");
                return false;
            } 
            else
            {
                var re = /^(?:[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&amp;'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
                var x= re.test(user);

                if (x) 
                {

                } 
                else
                {
                    alert("Gabim ne formatin e email-it.");
                    return false;
                }
            }
        }
    </script>
</head>
<!-------------------------HEADER--------------------------------------->

    <div class="content">
        <div class="container-fluid my-auto">
            <div class="row">
                <div class="col-lg-6">
                    <h3><br></h3>
                    <h4 class="menaxho"> Menaxhimi Pedagogëve </h4>
                </div>
            </div>
        </div>
        <br>
    <!------------------------------------Filteri Kerkimit------------------------------->
    <div class="container">
        <div class="d-flex shadow" style="height:350px;">

            <div class="border border-secondary col-sm-12">
                <h4 class="text-dark">Filtër Kërkimi</h4>
                <form action="pedagog.php" method="POST" name="myForm">
                    <div class="form-row align-items-center">
                        <?php
                        if (isset($_POST['emriFilter']))  //ne baze te emrit
                        {
                            $emriFilter = sanitizeString($_POST['emriFilter']);
                        } 
                        else 
                        {
                            $emriFilter = '';
                        }
                        ?>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="emriFilter"><p class="text-dark">Emri</p></label>
                                <input class="form-control" type="text" name="emriFilter" id="emriFilter"
                                       value="<?= $emriFilter ?>">
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['mbiemriFilter']))  //ne baze te mbiemrit
                        {

                            $mbiemriFilter = sanitizeString($_POST['mbiemriFilter']);
                        } 
                        else 
                        {
                            $mbiemriFilter = '';
                        }
                        ?>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="mbiemriFilter"><p class="text-dark">Mbiemri</p></label>
                                <input class="form-control" type="text" name="mbiemriFilter" id="mbiemriFilter"
                                       value="<?= $mbiemriFilter ?>">
                            </div>
                        </div>

                        <?php
                        if (isset($_POST['emailFilter']))  //ne baze te emailit
                        {
                            $emailFilter = sanitizeString($_POST['emailFilter']);
                        } else 
                        {
                            $emailFilter = '';
                        }
                        ?>
                        <div class="col-sm-4">
                            <div class="form-group"> 
                                <label for="emailFilter"><p class="text-dark">Email</p></label>
                                <input class="form-control" type="text" name="emailFilter" id="emailFilter"
                                       value="<?= $emailFilter ?>">
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_POST['roliFilter']))  //ne baze te rolit
                    {
                        $roliFilter = sanitizeString($_POST['roliFilter']);
                    } else
                    {
                        $roliFilter = '';
                    }
                    ?>

                    <div class="form-row align-items-center">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="roliFilter"><p class="text-dark">Roli</p></label>
                                    <select class="form-control" type="text" name="roliFilter" id="roliFilter">
                                        <option value="<?= $roliFilter ?>"><?= $roliFilter ?></option>
                                            <?php
                                            foreach ($pedagog as $row) 
                                            {
                                                echo "<option value='" . $row['pozicioni'] . "'>" . $row['pozicioni'] . "</option>";
                                            }
                                            ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-10">
                                <input type="submit" class="btn btn-outline-dark" name='filterKerkimi' value="Kërko">
                            </div>
                        </div>
                    <br><br>
                </form>
            </div>
        </div>

        <br><br><br><br>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Regjistro Pedagog
        </button>
        </span></strong>


        <!----------------------------------TABLE------------------------->
        <br>
        <table id="tabela" class="table table-hover">
            <thead class="thead-dark">
            <tr>
                <th><b>Emri</b></th>
                <th><b>Mbiemri</b></th>
                <th><b>Email</b></th>
                <th><b>Roli</b></th>
                <th><b>Titujt</b></th>
                <th><b>Adresa</b></th>
                <th><b>Gjinia</b></th>
                <th><b>Cel</b></th>
                <th colspan="3"><b>Veprime</b></th>
            </tr>
            </thead>
            <tbody style="background-color: white;">


            <?php

            if (isset($_POST['filterKerkimi'])) 
            {
                //nqs shtypet filter kerkimi nga forma per te kerkuar pedagog marrim perkatesisht cdo variabel kerkimi 
                //me ane te te cilit do kerkojme 
                $emriFilter = sanitizeString($_POST['emriFilter']);
                $roliFilter = sanitizeString($_POST['roliFilter']);
                $mbiemriFilter = sanitizeString($_POST['mbiemriFilter']);
                $emailFilter = sanitizeString($_POST['emailFilter']);

                //kerkojme ne query per pare nqs ekzistojne ne databaze per ta shfaqur 
                $showTableQuery = "SELECT * FROM pedagog INNER JOIN `user` ON user.user_email = pedagog.email WHERE 1=1 ";
                if ($emriFilter != '') 
                {
                    $showTableQuery .= " AND emri = '$emriFilter' ";
                }

                if ($mbiemriFilter != '') 
                {
                    $showTableQuery .= " AND mbiemri = '$mbiemriFilter' ";
                }

                if ($roliFilter != '') 
                {
                    $showTableQuery .= " AND pozicioni = '$roliFilter' ";
                }

                if ($emailFilter != '')
                {
                    $showTableQuery .= " AND email = '$emailFilter' ";
                }
                $resultStudent = queryMysql($showTableQuery);

                while ($row = $resultStudent->fetch_assoc()) 
                {
                    echo "<tr><td><span id='emri_" . $row['pedagog_id'] . "'> " . $row['emri'] . "</span></td>";
                    echo "<td><span id='mbiemri_" . $row['pedagog_id'] . "'>" . $row['mbiemri'] . "</span></td>";
                    echo "<td><span id='email_" . $row['pedagog_id'] . "'>" . $row['email'] . "</span></td>";
                    echo "<td><span id='roli_" . $row['pedagog_id'] . "'>" . $row['pozicioni'] . "</span></td>";
                    echo "<td><span id='titulli_" . $row['pedagog_id'] . "'>" . $row['titulli'] . "</span></td>";
                    echo "<td><span id='adresa_" . $row['pedagog_id'] . "'>" . $row['adresa'] . "</span></td>";
                    echo "<td><span id='gjinia_" . $row['pedagog_id'] . "'>" . $row['gjinia'] . "</span></td>";
                    echo "<td><span id='cel_" . $row['pedagog_id'] . "'>" . $row['tel'] . "</span></td>";

                    ?>

                    <td>
                        <button type="button" onClick="updateInput('<?php echo $row['email']; ?>');"
                                class="btn btn-outline-danger" data-toggle="modal" data-target="#fshij">
                            Fshij
                        </button>
                    </td>

                    <td>
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="#exampleModal" name=""
                                onClick="updateInput('<?php echo $row['email']; ?>');fillFields('<?php echo $row['pedagog_id']; ?>')">
                            Edit
                        </button>
                    </td>

                    <td>
                        <a target="_blank" href="pedagog2.php?prof_id=<?php echo $row['pedagog_id']; ?>"
                        <button type="button" class="btn btn-outline-dark">
                            Statistikat
                        </button>
                    </td>
                </tr>
                <?php
                }
            } 
            else 
            {
                $showTableQuery = "SELECT * FROM pedagog INNER JOIN user ON user.user_email = pedagog.email WHERE 1=1 ";
                $resultStudent = queryMysql($showTableQuery);

                while ($row = $resultStudent->fetch_assoc()) 
                {
                    echo "<tr><td><span id='emri_" . $row['pedagog_id'] . "'> " . $row['emri'] . "</span></td>";
                    echo "<td><span id='mbiemri_" . $row['pedagog_id'] . "'>" . $row['mbiemri'] . "</span></td>";
                    echo "<td><span id='email_" . $row['pedagog_id'] . "'>" . $row['email'] . "</span></td>";
                    echo "<td><span id='roli_" . $row['pedagog_id'] . "'>" . $row['pozicioni'] . "</span></td>";
                    echo "<td><span id='titulli_" . $row['pedagog_id'] . "'>" . $row['titulli'] . "</span></td>";
                    echo "<td><span id='adresa_" . $row['pedagog_id'] . "'>" . $row['adresa'] . "</span></td>";
                    echo "<td><span id='gjinia_" . $row['pedagog_id'] . "'>" . $row['gjinia'] . "</span></td>";
                    echo "<td><span id='cel_" . $row['pedagog_id'] . "'>" . $row['tel'] . "</span></td>";
                    ?>

                    <td>
                        <button type="button" onClick="updateInput('<?php echo $row['email']; ?>');"
                                class="btn btn-outline-danger" data-toggle="modal" data-target="#fshij">
                            Fshij
                        </button>
                    </td>

                    <td>
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="#exampleModal" name=""
                                onClick="updateInput('<?php echo $row['email']; ?>');fillFields('<?php echo $row['pedagog_id']; ?>')">
                            Edit
                        </button>
                    </td>

                    <td>
                        <a target="_blank" href="pedagog2.php?prof_id=<?php echo $row['pedagog_id']; ?>"
                        <button type="button" class="btn btn-outline-dark">
                            Statistikat
                        </button>
                    </td>
                </tr>
                <?php
                }
            }?>
            </tbody> 
        </table>
        <br><br>
    </div>
</div>
</div>
</div>
            <!-- Dritaret pop up qe do shfaqen ne momente qedo shtypet butoni fshii si te studentu  -->
    <div class="modal" id="fshij" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Po fshini</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span class="close" aria-hidden="true">&times;</span>
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
                        <input type="submit" name="butoni_fshirjes" value="Fshije" class="btn btn-outline-secondary">
                    </form>
                </div>

            </div>
        </div>
    </div>

                    <!-- NDRYSHIMI I TE DHENAVE  -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ndryshoni te dhenat</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span class="close" aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- DRITARJA QE DO SHFAQET  -->
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

        <form class="modal-content animate" method="post" action="pedagog.php" onsubmit="return validate();">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="studenti.png" alt="Avatar" class="avatar" style="width: 85px;height: 85px;">
            </div>

            <!-------------------------REGJISTRIMI PEDAGOGUT--------------------------------->
            <div class="container mt-2">
                <h3 id="regjistrimi">REGJISTRIMI I PEDAGOGUT </h3>
                <table align="center" cellpadding="10">

                    <tr>
                        <td>Emri*</td>
                        <td><input type="text" name="emri" id="emri" maxlength="30" required/>
                        </td>
                    </tr>

                    <tr>
                        <td>Mbiemri*</td>
                        <td><input type="text" name="mbiemri" id="mbiemri" maxlength="30" required/>
                        </td>
                    </tr>

                    <tr>
                        <td>Email</td>
                        <td>
                            <input type="email" name="email" id="email" maxlength="30" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>Adresa</td>
                        <td>
                            <input type="text" name="adresa" id="adresa" maxlength="30" required/>
                        </td>
                    </tr>

                    <tr>
                        <td>Nr. Telefonit/ Cel.</td>
                        <td>
                            <input type="text" name="cel" id="cel" maxlength="10" placeholder="06#########"/>

                        </td>
                    </tr>

                    <tr>
                        <td>Gjinia</td>
                        <td> Mashkull <input type="radio" name="gjinia" value="M"/>
                            Femer <input type="radio" name="gjinia" value="F"/>
                        </td>
                    </tr>

                    <tr>
                        <td>Roli</td>
                        <td><input type="text" name="roli" id="roli" maxlength="20" required/>
                        </td>
                    </tr>

                    <tr>
                        <td>Titulli</td>
                        <td><input type="text" name="titulli" maxlength="15" required/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input class="btn btn-outline-dark" class="text-center" type="submit" name="submitForma"
                                value="Submit">
                            <input class="btn btn-outline-dark" class="text-center" type="reset" value="Reset">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <button class="btn btn-outline-danger"
                                    onclick="document.getElementById('id01').style.display='none'"
                                    class="cancelbtn">Cancel
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>

    <script> //validimet njelloj si te studenti
        function updateInput(id) 
        {
            id = String(id);
            document.getElementById("fshij_student").value = id;
            document.getElementById("email_id_modal").value = id;

        }
        function fillFields(id) 
        {
            var emri = $("#emri_" + id).text();
            var mbiemri = $("#mbiemri_" + id).text();
            console.log(emri + ' ' + mbiemri);
            var cel = $("#tel_" + id).text();
            var adresa = $("#adresa_" + id).text();
            var roli = $("#pozicioni_" + id).text();
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

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.js"></script>


    <script>  
        $(document).ready(function () 
        {
            $('#tabela').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                "order": [[0, "desc"]],
                "searching": true
            })
        });
    </script>
</body>
</html>