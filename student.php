<!DOCTYPE html>
<?php

//PERFSHIME HEADER DHE SEK HEADER 
    include_once 'header.php';
    include_once 'sek_header.php';

    ///krijojme array per studentit nivelin degen vitin dhe grupit perkatesisht 
    $showTableQuery = "SELECT * FROM student Left JOIN `user` ON `user`.user_email = student.student_email 
    INNER JOIN klasa ON klasa.klasa_id = student.id_klase ";
    $resultStudent = queryMysql($showTableQuery);
    $student = array();
    $niveli = array();
    $dega = array();
    $viti = array();
    $grupi = array();

    //marrim cdo kolone nga klasa dhe i bejme fetch nga databasa 
    $result = queryMysql("SELECT * FROM klasa");
    $rowCount = $result->num_rows;
    while ($row = $result->fetch_assoc()) 
    {
        $niveli[$row['stadi']]['stadi'] = $row['stadi'];
        $dega[$row['dega']]['dega'] = $row['dega'];
        $viti[$row['viti']]['viti'] = $row['viti'];
        $grupi[$row['grupi']]['grupi'] = $row['grupi'];
    }

    //exit;
    ksort($grupi);

    //nqs shtypet forma me butonin submit 
    if (isset($_POST['submitForma'])) 
    {
        $error = "";
        //kalojme paramtrat 
        $emri = sanitizeString($_POST['emri']);
        $mbiemri = sanitizeString($_POST['mbiemri']);
        $emer_mbiemer = $emri . " " . $mbiemri;
        $atesia = sanitizeString($_POST['atesia']);
        $month = $_POST['month'];
        $dt = $_POST['dt'];
        $year = $_POST['year'];
        $date = "$year-$month-$dt";
        $email = sanitizeString($_POST['email']);
        $cel = sanitizeString($_POST['cel']);
        $gjinia = $_POST['gjinia'];
        $roli = 'student';
        $klasa_id = ($_POST['klasa']);
        $pass = generateRandomString();
        $password = passwordify($pass);
        $kredite = 0;
        $adresa = sanitizeString($_POST['adresa']);

        //validojme nqs te dhenat jane bosh 
        if (($emri == "") && ($mbiemri == "") && ($atesia == "") && ($email == "") && ($date == "") && ($cel == "") && ($gjinia == "") && ($password == ""))
            $error = 'Nuk jane futur gjithe te dhenat<br><br>';
        else  //nqs jo shtojme studentin dhe user pekatesisth
        {
            $result = queryMysql("SELECT * FROM user WHERE user_email='$email'");
            $rowCount = $result->num_rows;
            $insertUserQuery = "INSERT INTO `user` (user_email,password,roli,emri,mbiemri) VALUES('$email', '$password','$roli','$emri','$mbiemri')";
            $insertStudentQuery = "INSERT INTO `student` (student_email, emer_mbiemer,atesia, ditelindje, gjinia, id_klase, adresa, tel, kredite) VALUES('$email', '$emer_mbiemer','$atesia','$date','$gjinia','$klasa_id','$adresa','$cel','$kredite')";
            if ($rowCount != 0)
                $error = 'Eshte nje student i regjistruar me kete email.<br><br>';
            else 
            {
                if (queryMysql($insertUserQuery) && queryMysql($insertStudentQuery)) 
                {
                    echo("U ruajt studenti");
                    mail("$email", 'Regjistrimi', "I nderuar $emer_mbiemer, passwordi juaj eshte: $pass!", 'SMA');
                } 
                else 
                {
                    echo "Gabim:$error";
                }
            }
        }
    }

    //nqs nga forma shtypet butoni i fshirjes 
    if (isset($_POST['butoni_fshirjes'])) 
    {
        //bejme fshirjen ne baze te emailit
        $email = $_POST['fshij_student'];
        echo $email;
        $fshijQuery = "DELETE FROM `student` WHERE student_email ='$email'";
        $fshijQuery2 = "DELETE FROM `user` WHERE user_email ='$email'";
        $result = queryMysql($fshijQuery);
        $result2 = queryMysql($fshijQuery2);
    }

    //pst nqs nga forma shtypet butoni edit 
    if (isset($_POST['edit_student'])) 
    {
        $emri = sanitizeString($_POST['emri_modal']);
        $email_old = sanitizeString($_POST['email_id_modal']);
        $mbiemri = sanitizeString($_POST['mbiemri_modal']);
        $emrimbiemri = $emri . ' ' . $mbiemri;
        $adresa = sanitizeString($_POST['adresa_modal']);

        $cel = sanitizeString($_POST['cel_modal']);
        $kredite = sanitizeString($_POST['kredite_modal']);
        $grupi_id = sanitizeString($_POST['grupi_modal']);

        //i bejme update query ne baze te dritares qe shfaq forma
        $update_user_query = "UPDATE `user` SET emri='$emri', mbiemri='$mbiemri' WHERE user_email='$email_old'";
        $update_student_query = "UPDATE student SET emer_mbiemer='$emrimbiemri', id_klase='$grupi_id', adresa='$adresa',tel='$cel',kredite='$kredite' WHERE student_email='$email_old'";

        //nqs eshte query jo e suksesshme gabim user
        if (!queryMysql($update_user_query)) 
        {
            echo('Gabim user');
        }
        //dhe gabim student nqs eshte gabim query stuent
        if (!queryMysql($update_student_query)) 
        {
            echo('Gabim student');
        }
    }
?>

<!---------------------------------KODI HTML------------------------------------>

<html>
<head>
    <meta charset="utf-8">
    <title>Student</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous">
    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous">
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="student.js"></script>
    <script>
        //script qe validon nga forma e regjistrimit emrin mbiemrin emailin telefonin atesin 
        function validate()
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

            var atesiaFilter=document.getElementById("atesia").value;
            if(atesiaFilter=="")
            {
                alert(" Ju lutem shkruani mbiemrin");
                return false;
            } 
            else 
            {
                var atesiaRegex = /^[a-zA-Z\-]+$/;
                var y = atesiaRegex.test(atesiaFilter)

                if(y)
                {
                }
                else
                {
                    alert(" Gabim ne atesine. ");
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

<body>

    <!-------------------------HEADER--------------------------------------->

    <div class="content">
        <div class="container-fluid my-auto">
            <div class="row">
                <div class="col-lg-6">
                    <h3><br></h3>
                    <h4 class="menaxho"> Menaxhimi Studenteve  </h4>
                </div>
            </div>
        </div>
        <br>
        <div class="container">

            <!----------------------------------Butoni qe menxhon ndryshimin e Studenteve------------------------>
            <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Regjistro Student</button>

            <!-------------------------------------------------Tabela----------------------------------------------->
            <br>
            <table id="tabela" class="table table-hover">
                <thead class="table-dark">
                <tr>
                    <th scope="col">Emri</th>
                    <th scope="col">Atësia</th>
                    <th scope="col">Email</th>
                    <th scope="col">Adresa</th>
                    <th scope="col">Cel.</th>
                    <th scope="col">Ditëlindja</th>
                    <th scope="col">Gjinia</th>
                    <th scope="col">Kredite</th>
                    <th scope="col">Stadi</th>
                    <th scope="col">Dega</th>
                    <th scope="col">Viti</th>
                    <th scope="col">Grupi</th>
                    <th scope="col">Fshi</th>
                    <th scope="col">Edito</th>
                </tr>
                </thead>
                <?php //bejme fetch nga databaza tabelen student per te shfaqur krejt studentet 
                    $showTableQuery = "SELECT * FROM student 
                    Left JOIN `user` ON `user`.user_email = student.student_email 
                    INNER JOIN klasa ON klasa.klasa_id = student.id_klase ";
                    $resultStudent = queryMysql($showTableQuery);

                    while ($row = $resultStudent->fetch_assoc()) 
                    {
                        echo "<tr><td><span id='emer_mbiemer_" . $row['student_id'] . "'> " . $row['emer_mbiemer'] . "</span></td>";
                        echo "<td><span id='atesia_" . $row['student_id'] . "'>" . $row['atesia'] . "</span></td>";
                        echo "<td><span id='student_email_" . $row['student_id'] . "'>" . $row['student_email'] . "</span></td>";
                        echo "<td><span id='adresa_" . $row['student_id'] . "'>" . $row['adresa'] . "</span></td>";
                        echo "<td><span id='tel_" . $row['student_id'] . "'>" . $row['tel'] . "</span></td>";
                        echo "<td><span id='ditelindje_" . $row['student_id'] . "'>" . $row['ditelindje'] . "</span></td>";
                        echo "<td><span id='gjinia_" . $row['student_id'] . "'>" . $row['gjinia'] . "</span></td>";
                        echo "<td><span id='kredite_" . $row['student_id'] . "'>" . $row['kredite'] . "</span></td>";
                        echo "<td><span id='stadi_" . $row['student_id'] . "'>" . $row['stadi'] . "</span></td>";
                        echo "<td><span id='dega_" . $row['student_id'] . "'>" . $row['dega'] . "</span></td>";
                        echo "<td><span id='viti_" . $row['student_id'] . "'>" . $row['viti'] . "</span></td>";
                        echo "<td><span id='grupi_" . $row['student_id'] . "'>" . $row['grupi'] . "</span></td>";
                    ?>

                    <td>
                        <button type="button" class="btn btn-outline-danger"
                                onClick="updateInput('<?php echo $row['student_email']; ?>');"
                                data-toggle="modal" data-target="#fshij">
                            Fshi
                        </button>
                    </td>
                    <td>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                                data-target="#exampleModal" name=""
                                onClick="updateInput('<?php echo $row['student_email']; ?>');fillFields('<?php echo $row['student_id']; ?>')">
                            Edit
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </table>
        <br><br>
    </div>

        <!-- Disa modale qe kane te bejne me pop up si psh po fshini kete student dhe a jeni te sigurt qe doni ta fshini  -->
    <div class="modal" id="fshij" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"aria-hidden="true">
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
                    <form action="student.php" method="post">
                        <input type="hidden" name="fshij_student" id="fshij_student">
                        <input type="submit" class="btn-outline-danger" name="butoni_fshirjes" value="Fshini"
                            class="btn btn-primary">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-----------------------NDRYSHONI TE DHENAT------------>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content w-100">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ndryshoni te dhenat</h5>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span class="close mt-2" aria-hidden="true">&times;</span>
                    </button>
                </div>
            <!---------------------------------FORMA ------------------------------>

            <div class="modal-body">
                <form action="student.php" method="post" name="myForm">
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
                        <label for="kredite_modal">Kredite</label>
                        <input type="number" id='kredite_modal' name="kredite_modal" min="0" max="180">
                    </div>

                    <div class="form-group">
                        <label for="grupi_modal">Grupi</label>
                        <?php
                        $result = queryMysql("SELECT * FROM klasa"); //opsion qe do shfaqi zgjedhjen e klases per tu regjistruar
                        $rowCount = $result->num_rows;
                        echo "<select name='grupi_modal'>";
                        while ($row = $result->fetch_assoc()) 
                        {
                            $emri = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
                            echo "<option value='" . $row['klasa_id'] . "'>" . $emri . "</option>";
                        }
                        echo "</select>";
                        ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn-outline-dark" value="Edit" id="edit_student" name="edit_student">
                </div>
            </form>
        </div>

    </div>
</div>

<div id="id01" class="modal">

    <form class="modal-content animate" action="student.php" method="post" id="formaime"
          onsubmit=" return validate()">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="studenti.png" alt="Avatar" class="avatar">
        </div>

        <!-------------------------REGJISTRIMI STUDENTIT --------------------------------->
        <div class="container">
            <h3 id="regjistrimi">REGJISTRIMI I STUDENTIT</h3>
            <table align="center" cellpadding="10">

                <tr>
                    <td>Emri*</td>
                    <td><input type="text" name="emri" maxlength="30" required id="emri" />
                        <div id="emri_error" class="error hidden" style="color: red; visibility: hidden;"> Gabim ne emer.</div>
                    </td>
                </tr>

                <tr>
                    <td>Mbiemri*</td>
                    <td><input type="text" name="mbiemri" id="mbiemri" maxlength="30" required/>
                    </td>
                </tr>

                <tr>
                    <td>Atesia</td>
                    <td><input type="text" name="atesia" id="atesia" maxlength="30" required/>
                    </td>
                </tr>

                <tr>
                    <td>Ditelindja</td>
                    <td>
                        <select name="dt" id="dt">
                            <option>Dita:</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>

                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>

                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>

                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>

                            <option value="31">31</option>
                        </select>

                        <select id="month" name="month">
                            <option value="-1">Muaji:</option>
                            <option value="1">Janar</option>
                            <option value="2">Shkurt</option>
                            <option value="3">Mars</option>
                            <option value="4">Prill</option>
                            <option value="5">Maj</option>
                            <option value="6">Qershor</option>
                            <option value="7">Korrik</option>
                            <option value="8">Gusht</option>
                            <option value="9">Shtator</option>
                            <option value="10">Tetor</option>
                            <option value="11">Nentor</option>
                            <option value="12">Dhjetor</option>
                        </select>

                        <select name="year" id="year">
                            <option value="-1">Viti:</option>
                            <option value="2012">2012</option>
                            <option value="2011">2011</option>
                            <option value="2010">2010</option>
                            <option value="2009">2009</option>
                            <option value="2008">2008</option>
                            <option value="2007">2007</option>
                            <option value="2006">2006</option>
                            <option value="2005">2005</option>
                            <option value="2004">2004</option>
                            <option value="2003">2003</option>
                            <option value="2002">2002</option>
                            <option value="2001">2001</option>
                            <option value="2000">2000</option>

                            <option value="1999">1999</option>
                            <option value="1998">1998</option>
                            <option value="1997">1997</option>
                            <option value="1996">1996</option>
                            <option value="1995">1995</option>
                            <option value="1994">1994</option>
                            <option value="1993">1993</option>
                            <option value="1992">1992</option>
                            <option value="1991">1991</option>
                            <option value="1990">1990</option>

                            <option value="1989">1989</option>
                            <option value="1988">1988</option>
                            <option value="1987">1987</option>
                            <option value="1986">1986</option>
                            <option value="1985">1985</option>
                            <option value="1984">1984</option>
                            <option value="1983">1983</option>
                            <option value="1982">1982</option>
                            <option value="1981">1981</option>
                            <option value="1980">1980</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>
                        <input type="email" name="email" id="email" maxlength="30"/>
                    </td>
                </tr>

                <tr>
                    <td>Nr. Telefonit/ Cel.</td>
                    <td>
                        <input type="text" name="cel" id="celnr" maxlength="10" pattern="\d{10}\"
                               placeholder="06xxxxxxxx">

                        <div id="lbltext" style="color: red; visibility: hidden;">Please enter a valid phone number
                        </div>
                    </td>
                </tr>

                <tr>
                    <td>Gjinia</td>
                    <td> Mashkull <input type="radio" name="gjinia" value="M"/>
                        Femer <input type="radio" name="gjinia" value="F"/>
                    </td>
                </tr>

                <tr>
                    <td> Klasa</td>
                    <td>
                        <?php
                        $result = queryMysql("SELECT * FROM klasa"); //opsion qe do shfaqi klasen si zgjedhje
                        $rowCount = $result->num_rows;
                        echo "<select name='klasa'>";
                        while ($row = $result->fetch_assoc()) 
                        {
                            $emri = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
                            echo "<option value='" . $row['klasa_id'] . "'>" . $emri . "</option>";
                        }
                        echo "</select>";
                        ?>
                    </td>
                </tr>

                <tr>
                    <td> Adresa</td>
                    <td>
                        <input type="text" name="adresa" maxlength="40"/>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input class="btn btn-outline-dark" class="text-center" type="submit" name="submitForma" value="Submit">
                        <input  class="btn btn-outline-dark" class="text-center" type="reset" value="Reset">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button class="btn-outline-danger"
                                onclick="document.getElementById('id01').style.display='none'"
                                class="cancelbtn">Cancel
                        </button>
                    </td>
                </tr>

            </table>
        </div>

    </form>

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
    
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous">
    </script>

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.js"></script>

    <script>  //skripte qe kane te bejne shkarkimin e tabelave si dokument pdf excel ose copy billboard,
    // funks data table qe realizon scrollet sorting etj
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

    <script>
        function updateInput(id) //updatimi
        {
            id = String(id);
            document.getElementById("fshij_student").value = id;
            document.getElementById("email_id_modal").value = id;

        }

        function fillFields(id)  //plotesimi i fushave 
        {
            var emer_mbiemer = $("#emer_mbiemer_" + id).text();
            var array = emer_mbiemer.split(" ");
            var emri = array[1];
            var mbiemri = array[2];
            console.log(emer_mbiemer + ' ' + emri + ' ' + mbiemri);
            var cel = $("#cel_" + id).text();
            var student_adresa = $("#student_adresa_" + id).text();
            var kredite = $("#kredite_" + id).text();
            var niveli = $("#niveli_" + id).text();
            var dega = $("#dega_" + id).text();
            var viti = $("#viti_" + id).text();
            var grupi = $("#grupi_" + id).text();
            var grupi_mod = niveli + ':' + dega + ' ' + viti + ' ' + grupi;
            $("#emri_modal").val(emri);
            $("#mbiemri_modal").val(mbiemri);
            console.log(mbiemri);
            $("#adresa_modal").val(student_adresa);
            $("#cel_modal").val(cel);
            $("#kredite_modal").val(kredite);
            $("#grupi_modal").val(grupi_mod);
        }
    </script>

    <script>
         $(document).ready(function()
        {
            $("#welcome").hide();
        });
    </script>
</body>
</html>