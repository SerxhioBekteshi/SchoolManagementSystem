<!DOCTYPE html>
<?php
    include_once 'header.php';
    include_once 'sek_header.php';

    //nqs niveli dega grupi dhe viti jane vlera jo boshe qe marrim nga forma 
    if (isset($_POST['niveli']) && isset($_POST['dega']) && isset($_POST['viti']) && isset($_POST['grupi'])) 
    {
        $error = ""; //i ruajme perkatesisht neper variabla
        $niveli = $_POST["niveli"];
        $viti = $_POST['viti'];
        $dega = $_POST['dega'];
        $grupi = sanitizeString($_POST['grupi']);
        if (($niveli == "") && ($dega == "") && ($viti == "") && ($grupi == ""))
            $error = 'Nuk jane futur gjithe te dhenat<br><br>'; //nqs i kemi lene bosh gjate plotesisimit shfaqim mesazhin
        else 
        {
            //ne te kundert shtojme ne tabelen klase variablat perkatesse 
            $result = queryMysql("SELECT * FROM klasa WHERE stadi='$niveli' AND dega='$dega' AND viti='$viti' AND grupi='$grupi'");
            $rowCount = $result->num_rows;
            if ($rowCount != 0)
                $error = 'Eshte nje klase e tille e regjistruar.<br><br>';
            else 
            {
                //nqs query e suksesshme
                if (queryMysql("INSERT INTO klasa (stadi,dega,viti,grupi) VALUES('$niveli', '$dega','$viti','$grupi')"))
                    echo("U ruajt klasa $niveli|$dega|$viti|$grupi");
                else //nqs jo
                {
                    echo "Gabim:$error";
                }
            }
        }
    }

    if (isset($_POST['butoni_fshirjes'])) //mundesia per te fshire nje klase 
    {
        $id = $_POST['fshij_id'];
        echo $id;
        $fshijQuery = "DELETE FROM klasa WHERE klasa_id ='$id'";
        $result = queryMysql($fshijQuery);
    }

?>
<html>
<head>
    <meta charset="utf-8">
    <title>Student</title>
    <!-- Bootstrap CSS -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://unpkg.com/sweetalert2@7.8.2/dist/sweetalert2.all.js"></script>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="student.js"></script>
</head>
<body>
<!-------------------------HEADER--------------------------------------->
<div class="content">
    <div  class="container-fluid my-auto">
        <div class="row">
            <div class="col-lg-6">
                <h3><br> </h3>
                <h4 class="menaxho"> Menaxhimi Grupeve </h4>
            </div>
        </div>
    </div>
    <!-------------------------------------HEADER--------------------------------------------->

    <!----------------------------------------------Button -------------------------------------->
    <button type="button" data-toggle="modal" data-target="#id01" style="width:auto;">Shto klase</button></span></strong>


    <br><br><br><br>
    <!------------------------------TABELA---------------------------------------------------->
    <table class="table table-hover">
        <thead class="table-dark">
        <tr>
            <th scope="col">Stadi</th>
            <th scope="col">Dega</th>
            <th scope="col">Viti</th>
            <th scope="col">Klasa</th>
            <th scope="col">Fshi</th>
        </tr>
        </thead>
        <?php
        $showTableQuery = "SELECT * FROM klasa ORDER BY stadi ASC, dega ASC, viti ASC, grupi ASC";

        if (isset($_POST['submitSearch'])) //nqs shtojme butonit search kerkojme ne baze te variablave te marrra nga forma 
         {
            $search = sanitizeString($_POST['searchField']);
            $searchQuery = "SELECT * FROM klasa WHERE stadi LIKE '%$search%' OR dega LIKE '%$search%' ORDER BY stadi ASC, dega ASC, viti ASC, grupi ASC";
            $searchResult = queryMysql($searchQuery);
            while ($row = $searchResult->fetch_assoc()) 
            {
                echo "<tr><td>" . $row['stadi'] . "</td>";
                echo "<td>" . $row['dega'] . "</td>";
                echo "<td>" . $row['viti'] . "</td>";
                echo "<td>" . $row['grupi'] . "</td>";
                ?>
                <td> 
                    <button type="button" onClick="updateInput(<?php echo $row['klasa_id']; ?>);" 
                            class="btn btn-outline-danger" data-toggle="modal" data-target="#fshij"> 
                        Fshi
                    </button>
                </td>
                </tr>

                <?php
            }
        } 
        else 
        { //nqs nuk shtypet shfaqim komplet tabelen perkatese 
            $tableResult = queryMysql($showTableQuery);
            while ($row = $tableResult->fetch_assoc()) 
            {
                echo "<tr id='".$row['klasa_id']."'><td>" . $row['stadi'] . "</td>";
                echo "<td>" . $row['dega'] . "</td>";
                echo "<td>" . $row['viti'] . "</td>";
                echo "<td>" . $row['grupi'] . "</td>";
                ?>

                <td>
                    <button type="button" onClick="sweet(<?php echo $row['klasa_id']; ?>);"
                            class="btn btn-outline-danger" >
                        Fshi
                    </button>

                </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <br><br><br>

</div>

<div id="id01" class="modal">
        <!--------------------------- FORMA PER TE REGJISTRUAR NJE GRUP  --------------->
    <form class="modal-content animate" action="grupi.php" method="post">
        <div class="imgcontainer">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="studenti.png" alt="Avatar" class="avatar">
        </div>

        <div class="container">
            <h3 id="regjistrimi">REGJISTRIMI I GRUPIT</h3>
            <table align="center" cellpadding="10">

                <tr>
                    <td>Dega</td>
                    <td>
                        Ing.Informatike <input type="radio" name="dega" value="Inxhinieri Informatike"/>
                        Ing.Elektronike <input type="radio" name="dega" value="Inxhineri Elektronike"/>
                        Ing.Telekomunikacioni <input type="radio" name="dega" value="Inxhinieri Telekomunikacioni"/>
                    </td>
                </tr>

                <tr>
                    <td> Stadi </td>
                    <td>

                        Bachelor <input type="radio" name="niveli" value="Bachelor"/>
                        Msc. Shkencor <input type="radio" name="niveli" value="Master Shkencor"/>
                        Msc. Profesional <input type="radio" name="niveli" value="Master Profesional"/>
                    </td>
                </tr>

                <tr>
                    <td> Viti Akademik</td>
                    <td>
                        <select name="viti" id="viti">
                            <option value="1">Viti 1</option>
                            <option value="2">Viti 2</option>
                            <option value="3">Viti 3</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Grupi</td>
                    <td><input type="text" name="grupi" maxlength="1"/>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input  class="btn btn-outline-secondary" class="text-center" type="submit" value="Submit">
                        <input  class="btn btn-outline-secondary" class="text-center" type="reset" value="Reset">
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="right">
                        <button  class="btn btn-outline-danger" onclick="document.getElementById('id01').style.display='none'"
                                 class="cancelbtn">Cancel
                        </button>
                    </td>
                </tr>

            </table>
        </div>
    </form>

</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
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

    <script>
        function updateInput(id) //script per updatim 
        {
            document.getElementById("fshij_id").value = id;
        }

        function deleteRow(rowid) //script per te fshire nje rersht nga tabela 
        {
            var row = document.getElementById(rowid);
            var table = row.parentNode;
            while (table && table.tagName != 'TABLE')
                table = table.parentNode;
            if (!table)
                return;
            table.deleteRow(row.rowIndex);
        }

        function sweet(id) //dritaret pop up qe do shfaqen pasi shtypet butoni fshi
        {

            Swal.fire({
                title: 'Are you sure?',
                type: "{{ session('flash_message_email.level') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'


            }).then((result) => 
            {
                if (result.isConfirmed) 
                {
                    var data = {
                        "action": "delete_klase",
                        "id": id
                    }

                    $.ajax({
                        url: "ajax.php",
                        type: "POST",
                        method: "POST",
                        data: data,
                        cache: false,

                        success: function (response)
                         {
                            var res = JSON.parse(response);
                            if (res.status == 200) 
                            {

                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'success'
                                )
                                deleteRow(id);


                            } 
                            else 
                            {
                                Swal.fire(
                                    'Deleted!',
                                    res.message,
                                    'error'
                                )
                            }
                        },
                    });
                }
            })
        }
    </script>

</body>
</html>