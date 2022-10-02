<!DOCTYPE html>
<?php
    include_once 'header.php';
    include_once 'sek_header.php';


    /**
     * Mbushja e arrayt me klasat e studenteve
     */
    $student_klase = array();
    $klasat_e_studenteve_query = "SELECT * FROM klasa";
    $result_klaset = mysqli_query($connection, $klasat_e_studenteve_query);
    while ($row = mysqli_fetch_assoc($result_klaset)) 
    {
        $student_klase[$row['klasa_id']]['id'] = $row['klasa_id'];
        $student_klase[$row['klasa_id']]['klasa'] = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
    }

    //mbushja e arrayt me pedagoget
    $mesues = array();
    $mesues_query = "SELECT pedagog_id,emri,mbiemri,email FROM pedagog";
    $result_mesues = mysqli_query($connection, $mesues_query);
    while ($row = mysqli_fetch_assoc($result_mesues)) 
    {
        $mesues[$row['pedagog_id']]['id'] = $row['pedagog_id'];
        $mesues[$row['pedagog_id']]['email'] = $row['email'];
        $mesues[$row['pedagog_id']]['full_name'] = $row['emri'] . ' ' . $row['mbiemri'];
    }


    /**
     * Mbushja e arrayt me lende
     */
    $lendet = array();
    $lenda_query = "SELECT * FROM lenda";
    $result_lenda = mysqli_query($connection, $lenda_query);
    while ($row = mysqli_fetch_assoc($result_lenda)) 
    {
        $lendet[$row['lenda_id']]['id'] = $row['lenda_id'];
        $lendet[$row['lenda_id']]['lenda'] = $row['emertimi'];
    }

    /**
     * Mbushja e arrayt me lende
     */
    $data = array();
    $data_query = "SELECT * FROM klase_lende";
    $result_data = mysqli_query($connection, $data_query);
    while ($row = mysqli_fetch_assoc($result_data)) 
    {
        $data[$row['klase_lende_id']]['id'] = $row['klase_lende_id'];
        $data[$row['klase_lende_id']]['id_klase'] = $row['id_klase'];
        $data[$row['klase_lende_id']]['lenda_id'] = $row['lenda_id'];
        $data[$row['klase_lende_id']]['pedagog_id'] = $row['pedagog_id'];
        $data[$row['klase_lende_id']]['kredite'] = $row['kredite'];
        $data[$row['klase_lende_id']]['semestri'] = $row['semestri'];
        $data[$row['klase_lende_id']]['pedagog'] = $mesues[$row['pedagog_id']]['full_name'];
        $data[$row['klase_lende_id']]['email'] = $mesues[$row['pedagog_id']]['email'];
        $data[$row['klase_lende_id']]['lenda'] = $lendet[$row['lenda_id']]['lenda'];
        $data[$row['klase_lende_id']]['student_klase_emri'] = $student_klase[$row['id_klase']]['klasa'];
    }


    if (isset($_POST['lenda_submit'])) //nqs shtypet butoni lenda submit nga forma per ta shtuar 
    {
        $error = "";
        $lenda = sanitizeString($_POST['lenda']);
        if (($lenda == "")) //nqs bosh shfaqet meszhi
            $error = 'Nuk jane futur gjithe te dhenat<br><br>';
        else 
        {
           //marrim query dhe i bejme insert ku nqs i suksesshem shtohet, dhe nqs jo shfaqen gabimet, nqs lenda ekziston
            //mesazh qe kjo lende eshte regjistruar
            $result = queryMysql("SELECT * FROM lenda WHERE emertimi='$lenda'");
            $rowCount = $result->num_rows;
            if ($rowCount != 0)
                $error = 'Eshte nje lende e tille e regjistruar.<br><br>';
            else 
            {
                if (queryMysql("INSERT INTO lenda (emertimi) VALUES('$lenda')"))
                    echo("U ruajt lenda $lenda");
                else 
                {
                    echo "Gabim:$error";
                }
            }
        }
    }

    //caktimi i lendes per nje klase te caktuar
    if (isset($_POST['submitFormen'])) 
    {
        $error = "";
        $semestri= sanitizeString($_POST['semestri']);
        $kredite= sanitizeString($_POST['kredite']);
        $lenda = sanitizeString($_POST['lenda']);
        $klasa = sanitizeString($_POST['klasa']);
        $mesues = sanitizeString($_POST['mesues']);
        if (($lenda == "") || ($klasa == "") || ($mesues == ""))
            $error = 'Nuk jane futur gjithe te dhenat<br><br>';
        else 
        { 
            $resulttt=queryMysql("INSERT INTO klase_lende (id_klase,lenda_id,pedagog_id,kredite,semestri) VALUES('$klasa','$lenda','$mesues','$semestri','$kredite')");
            if ($resulttt) 
            {
                echo("U ruajt lenda $lenda");
                $update_url='lendetPhp.php';
                echo "<script>window.location.href = $update_url</script>";
            }
            else 
            {
                echo "Gabim:$error";
            }
        }
    }

    //logjike e ngjashme dhe per editimi ashtu si shtimi i lendes \
    //por te query do kemi update ne databaze dhe jo insert into 
    if (isset($_POST['editFormen'])) 
    {
        $error = "";
        $modal = sanitizeString($_POST['modali_edit']);
        $semestri= sanitizeString($_POST['semestri_modal']);
        $kredite= sanitizeString($_POST['kredite_modal']);
        $lenda = sanitizeString($_POST['lenda_modal']);
        $klasa = sanitizeString($_POST['klasa_modal']);
        $mesues = sanitizeString($_POST['mesues_modal']);
        if (($lenda == "") || ($klasa == "") || ($mesues == ""))
            $error = 'Nuk jane futur gjithe te dhenat<br><br>';
        else 
        {
            $result = queryMysql("UPDATE klase_lende set id_klase='$klasa',pedagog_id='$mesues',lenda_id='$lenda', kredite='$kredite', semestri='$semestri' where klase_lende_id='$modal'");
            if ($result)
                echo("U ruajt lenda $lenda");
            else 
            {
                echo "Gabim:$error";
            }
        }
    }


    if (isset($_POST['butoni_fshirjes'])) //dhe mundesia per ta fshire 
    {
        $error = "";
        $modal = $_POST['fshij_student'];
        $fshijQuery = "DELETE FROM klase_lende WHERE klase_lende_id ='$modal'";
        $result = queryMysql($fshijQuery);

    }

?>
<html>
<head>
    <meta charset="utf-8">
    <title>LENDET</title>
    <link rel="stylesheet" type="text/css" href="sekretaria.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="student.js"></script>
</head>
<body>
    <!-------------------------HEADER--------------------------------->
    <div class="content">
        <div class="container-fluid my-auto">
            <div class="row">
                <div class="col-lg-6">
                    <h3><br></h3>
                    <h4 class="menaxho"> Menaxhimi Lëndëve </h4>
                </div>
            </div>
        </div>
        <!--------------BUTON------------------------------------------>
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Shto Lënd</button>
        <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;">Cakto Lëndët</button>

        <br><br><br><br>

        <!------------------------------TABELA------------------------>
        <table name="tabela2" id="tabela2" class="table table-hover">
            <thead class="table-dark">
            <tr>
                <th scope="col">Lënda</th>
                <th scope="col">Pedagog</th>
                <th scope="col">Dega</th>
                <th scope="col">Semestri</th>
                <th scope="col">Kredite</th>
                <th scope="col">Fshi</th>
                <th scope="col">Edito</th>
            </tr>
            </thead>
            <?php
            $table_data_query = "SELECT * FROM klase_lende 
                                inner join pedagog on pedagog.pedagog_id = klase_lende.pedagog_id
                                inner join lenda on lenda.lenda_id  = klase_lende.lenda_id
                                inner join klasa  on klasa.klasa_id  = klase_lende.id_klase";
            $result_table_data = mysqli_query($connection, $table_data_query);
            while ($row = mysqli_fetch_assoc($result_table_data)) 
            {
                $id=$row['klase_lende_id'];
                echo "<tr><td><span id='lenda_" . $id . "'>" . $row['emertimi'] . "</span> </td>";
                echo "<td><span id='pedagog_" . $id . "'>" . $row['emri'].' '. $row['mbiemri'] . "</span> </td>";
                echo "<td><span id='klasa_" . $id . "'>" . $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'] . "</span> </td>";
                echo "<td><span id='semestri_" . $id . "'>" . $row['semestri'] . "</span> </td>";
                echo "<td><span id='kredite_" . $id . "'>" . $row['kredite'] . "</span> </td>";
            ?>
                <td>
                    <button type="button" class="btn btn-outline-danger" onClick="updateInput('<?php echo $id; ?>');"
                            data-toggle="modal" data-target="#fshij">
                        Fshi
                    </button>
                </td>

                <!------------------------------- Button trigger modal -------------------------------->
                <td>
                    <button type="button" class="btn btn-outline-dark" data-toggle="modal"
                            data-target="#id022" name=""
                            onClick="updateInput('<?php echo $id; ?>');fillFields('<?php echo $id; ?>')">
                        Edit
                    </button>
                </td>
            </tr>
                <?php } ?>
        </table>
    </div>

    <!-------------------------------------------MODAL --------------------------------------------------->

    <div id="id01" class="modal">
        <form class="modal-content animate" method="post" action="lendet.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="studenti.png" alt="Avatar" class="avatar">
            </div>

            <!--------------------------------REGJISTRIMI STUDENTIT --------------------------------->
            <div class="container">
                <h3 id="regjistrimi">Shto Lëndë</h3>
                <table align="center" cellpadding="10">

                    <tr>
                        <td>Titulli Lëndës</td>
                        <td><input type="text" name="lenda" maxlength="30" required/>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input class="text-center" class="btn btn-outline-dark" name="lenda_submit" type="submit" value="Submit">
                            <input class="text-center" class="btn btn-outline-dark" autocomplete="off" type="reset"
                                value="Reset">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <button onclick="document.getElementById('id01').style.display='none'"
                                    class="btn btn-outline-danger">Cancel
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>

    <!---------------------------------MODAL FSHI -------------------------------------------->
    <div class="modal" id="fshij" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <!-- Dritaret pop up qe qe do shfaqen perkatesisht nqs shtypet butoni i caktuar  -->
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
                    <form action="lendet.php" method="post">
                        <input type="hidden" name="fshij_student" id="fshij_student">
                        <input type="submit" name="butoni_fshirjes" value="Fshije" class="btn btn-outline-info">
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div id="id022" class="modal">
        <form class="modal-content animate" method="post" action="lendet.php">
            <input type="hidden" id="modali_edit" name="modali_edit">
                <div class="imgcontainer">
                    <span onclick="document.getElementById('id022').style.display='none'" class="close" title="Close Modal">&times;</span>
                    <img src="studenti.png" alt="Avatar" class="avatar">
                </div>

            <!-------------------------REGJISTRIMI STUDENTIT --------------------------------->
            <div class="container">
                <h3 id="regjistrimi">Cakto Lëndë</h3>
                <table align="center" cellpadding="10">

                    <tr>
                        <td>Titulli Lëndës</td>
                        <td>
                            <select name="lenda_modal">
                                <option></option>
                                <?php
                                foreach ($lendet as $id => $value) 
                                {
                                    echo "<option value='" . $id . "'>" . $value['lenda'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Pedagog</td>
                        <td>
                            <select name="mesues_modal">
                                <option></option>
                                <?php
                                foreach ($mesues as $id => $values) 
                                {
                                    echo "<option value='" . $id . "'>" . $values['full_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Klasa</td>
                        <td>
                            <select name="klasa_modal">
                                <option></option>
                                <?php
                                foreach ($student_klase as $id => $value) 
                                {
                                    echo "<option value='" . $id . "'>" . $value['klasa'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Kredite</td>
                        <td>
                            <input type="number" min="2" max="12" name="kredite_modal" id="kredite_modal">
                        </td>
                    </tr>

                    <tr>
                        <td>Semestri</td>
                        <td>
                            <input type="number" min="1" max="10" name="semestri_modal" id="semestri_modal">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input class="text-center" class="btn btn-outline-dark" name="editFormen" type="submit" value="Submit">
                            <input class="text-center" class="btn btn-outline-dark" autocomplete="off" type="reset"
                                value="Reset">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <button type="bt" onclick="document.getElementById('id022').style.display='none'"
                                    class="btn btn-outline-danger">Cancel
                            </button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </div>



    <div id="id02" class="modal">
        <form class="modal-content animate" method="post" action="lendet.php">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="studenti.png" alt="Avatar" class="avatar">
            </div>

            <!-------------------------REGJISTRIMI STUDENTIT --------------------------------->
            <div class="container">
                <h3 id="regjistrimi">Cakto Lëndë</h3>
                <table align="center" cellpadding="10">

                    <!----- First Name ---------------------------------------------------------->
                    <tr>
                        <td>Titulli Lëndës</td>
                        <td>
                            <select name="lenda">
                                <option></option>
                                <?php
                                foreach ($lendet as $id => $value) 
                                {
                                    echo "<option value='" . $id . "'>" . $value['lenda'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Pedagog</td>
                        <td>
                            <select name="mesues">
                                <option></option>
                                <?php
                                foreach ($mesues as $id => $values) 
                                {
                                    echo "<option value='" . $id . "'>" . $values['full_name'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Klasa</td>
                        <td>
                            <select name="klasa">
                                <option></option>
                                <?php
                                foreach ($student_klase as $id => $value) 
                                {
                                    echo "<option value='" . $id . "'>" . $value['klasa'] . "</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td>Kredite</td>
                        <td>
                            <input type="number" min="2" max="12" name="kredite" id="kredite">
                        </td>
                    </tr>

                    <tr>
                        <td>Semestri</td>
                        <td>
                            <input type="number" min="1" max="10" name="semestri" id="semestri">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="center">
                            <input class="text-center" class="btn btn-outline-dark" name="submitFormen" type="submit" value="Submit">
                            <input class="text-center" class="btn btn-outline-dark" autocomplete="off" type="reset"
                                value="Reset">
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" align="right">
                            <button type="bt" onclick="document.getElementById('id02').style.display='none'"
                                    class="btn btn-outline-danger">Cancel
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

    <link 
        rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.js"></script>

    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
                           
    <script>
        $(document).ready(function ()  //skript i njejte per tabelen 
        {
            $('#tabela2').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                "order": [[0, "desc"]],
                "searching": true

            })
        });

        function updateInput(id) 
        {
            id = String(id);
            document.getElementById("fshij_student").value = id;
            document.getElementById("modali_edit").value = id;

        }

        function fillFields(id) 
        {
            var lenda = $("#lenda_" + id).text();
            var pedagog = $("#pedagog_" + id).text();
            var klasa = $("#klasa_" + id).text();
            var semestri = $("#semestri_" + id).text();
            var kredite = $("#kredite_" + id).text();
            console.log(lenda + ' ' + pedagog + ' ' + klasa + ' ' + seminar_leksion)
            $("#mesues_modal").val(pedagog);
            $("#klasa_modal").val(klasa);
            $("#lenda_modal").val(lenda);
            $("#semestri_modal").val(semestri);
            $("#kredite_modal").val(kredite);
        }
    </script>

</body>
</html>