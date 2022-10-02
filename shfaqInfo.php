<?php
    include_once 'functions.php';
    require_once 'header.php';
    include_once 'prof_header.php';
    $emaili = $_SESSION['user'];

    $mesues_id = $_SESSION['pedagog_id'];


    $queryklasave = "SELECT * FROM klasa";
    $result_klasave = queryMysql($queryklasave);
    $klaset = array();
    while ($row = $result_klasave->fetch_assoc()) 
    {
        $klaset[$row['klasa_id']]['klasa_id'] = $row['klasa_id'];
        $klaset[$row['klasa_id']]['klasa'] = $row['stadi'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
    }

    $querylendeve = "SELECT * FROM lenda";
    $result_lendeve = queryMysql($querylendeve);
    $lendet = array();
    while ($row = $result_lendeve->fetch_assoc()) 
    {
        $lendet[$row['lenda_id']]['lenda_id'] = $row['lenda_id'];
        $lendet[$row['lenda_id']]['lenda'] = $row['emertimi'];
    }


    $query_mungesat = "SELECT * FROM klase_lende inner join klasa on klasa.klasa_id=klase_lende.id_klase 
    inner join lenda on lenda.lenda_id = klase_lende.lenda_id 
    inner join mungesa on mungesa.klase_lende_id =klase_lende.klase_lende_id 
    inner join student on mungesa.student_id=student.student_id 
    where mungesa.pedagog_id = '$mesues_id' ";
    $result = queryMysql($query_mungesat);;
    $tedhenat = array();
    while ($row = $result->fetch_assoc()) 
    {
        if (!isset($tedhenat[$row['klase_lende_id']][$row['student_id']]['mungesa'])) 
        {
            $tedhenat[$row['klase_lende_id']][$row['student_id']]['mungesa'] = 0;
        }
        if (!isset($tedhenat[$row['klase_lende_id']][$row['student_id']]['seminare'])) 
        {
            $tedhenat[$row['klase_lende_id']][$row['student_id']]['seminare'] = 0;
        }

        $tedhenat[$row['klase_lende_id']][$row['student_id']]['student_id'] = $row['student_id'];
        $tedhenat[$row['klase_lende_id']][$row['student_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
        $tedhenat[$row['klase_lende_id']][$row['student_id']]['klase_lende_id'] = $row['klase_lende_id'];
        $tedhenat[$row['klase_lende_id']][$row['student_id']]['titulli_lendes'] = $row['emertimi'];
        $tedhenat['titulli_lendes'] = $row['emertimi'];
        $tedhenat[$row['klase_lende_id']][$row['student_id']]['klasa'] = $row['stadi'] . ":" . $row['dega'] . " " . $row['viti'] . " " . $row['grupi'];
        if ($row['prezent'] == 'jo') 
        {
            $tedhenat[$row['klase_lende_id']][$row['student_id']]['mungesa']++;
        }
        $tedhenat[$row['klase_lende_id']][$row['student_id']]['seminare']++;

    }

    function mesatarja($notat, $numri)
    {
        $shuma = 0;
        foreach ($notat as $nota) 
        {
            $shuma += $nota;
        }
        if ($numri == 0)
            return 0;
        return $shuma / $numri;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/javascript" href="student.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script
            src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"
          integrity="sha512-C7hOmCgGzihKXzyPU/z4nv97W0d9bv4ALuuEbSf6hm93myico9qa0hv4dODThvCsqQUmKmLcJmlpRmCaApr83g=="
          crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"
            integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw=="
            crossorigin="anonymous"></script>
</head>
<body>


<!------------------------------CONTENT------------------------------->
    <div class="content">
        <div class="container">
            <br><br>
            <h2> Te dhenat </h2><br>
            <br><br>
            <table id="mungesat" class="table table-hover">
                <thead class="table-dark">
                <tr>
                    <th>Studenti</th>
                    <th>Lenda</th>
                    <th>Klasa</th>
                    <th>Numri i seminareve</th>
                    <th>Mungesat</th>
                    <th>Raporti mungesa/seminare</th>
                </tr>
                </thead>
                <?php
                foreach ($tedhenat as $stud_klase_key => $mungesa_info_value) 
                {
                    if ($stud_klase_key == 'titulli_lendes') 
                    {
                    continue;
                    }
                    foreach ($mungesa_info_value as $stud_id => $info_value) 
                    {?>
                        <tr>
                            <td><?= $info_value['emer_mbiemer'] ?></td>
                            <td><?= $info_value['titulli_lendes'] ?></td>
                            <td><?= $info_value['klasa'] ?></td>
                            <td><?= $info_value['seminare'] ?></td>
                            <td><?= $info_value['mungesa'] ?></td>
                            <td><?php echo round((($info_value['mungesa'] / $info_value['seminare']) * 100), 2) . '%'; ?></td>
                        </tr>
                    <?php }
                } ?>
                <tfoot>
                <th>Studenti</th>
                <th>Lenda</th>
                <th>Klasa</th>
                <th>Numri i seminareve</th>
                <th>Mungesat</th>
                <th>Raporti mungesa/seminare</th>
                </tfoot>
            </table>
            <br><br>
            <h2> Notat</h2><br>
            <table id="notat" class="table table-hover">
                <thead class="table-dark">
                <th>Studenti</th>
                <th>Lenda</th>
                <th>Klasa</th>
                <th>Nota</th>
                </thead>
                <?php
                $query_notat = "SELECT * FROM klase_lende right join klasa on klasa.klasa_id=klase_lende.id_klase
                right join lenda on lenda.lenda_id=klase_lende.lenda_id 
                right join provim on  klase_lende.pedagog_id =provim.pedagog_id
                right join student on student.student_id=provim.studenti_id  
                where provim.pedagog_id  = '$mesues_id' ";
                $result_notat = queryMysql($query_notat);
                $provimet = array();
                while ($row = $result_notat->fetch_assoc()) 
                {
                    $provimet[$row['student_id']][$row['klase_lende_id']]['student_id'] = $row['student_id'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['klase_lende_id'] = $row['klase_lende_id'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['titulli_lendes'] = $row['emertimi'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['nota'] = $row['nota'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['data'] = $row['viti_provimit'];
                    $provimet[$row['student_id']][$row['klase_lende_id']]['klasa'] = $row['stadi'] . ":" . $row['dega'] . " " . $row['viti'] . " " . $row['grupi'];
                }

                $notat = array();
                foreach ($provimet as $stud_id_key => $nota_info_value) 
                {
                    foreach ($nota_info_value as $klase_lende_id => $infot) 
                    {
                        $notat[] = $infot['nota'];
                    }
                }
                foreach ($provimet as $stud_id_key => $nota_info_value) 
                {
                    foreach ($nota_info_value as $klase_lende_id => $infot) 
                    { ?>
                        <tr>
                            <td><?= $infot['emer_mbiemer'] ?></td>
                            <td><?= $lendet[$_SESSION['klase_lende'][$klase_lende_id]['lenda_id']]['lenda'] ?></td>
                            <td><?= $klaset[$_SESSION['klase_lende'][$klase_lende_id]['id_klase']]['klasa'] ?></td>
                            <td><?= $infot['nota'] ?></td>
                        </tr>
                        <?php
                    }
                }
            ?>
            <tfoot>
            <th colspan="4">Mesatarja: <?= round(mesatarja($notat, count($notat)), 2) ?> </th>
            </tfoot>
        </table>
        <?php
        foreach ($notat as $nota) 
        {
            if (!isset($numri)) 
            {
                $numri = 0;
            }

            if (!isset($kalues)) 
            {
                $kalues = 0;
            }
            if ($nota > 4) 
            {
                $kalues++;
            }
            $numri++;
        } ?>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <canvas id="myChart" width="200" height="200"></canvas>
                </div>
            </div>
        </div>

        <script>
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, 
            {
                type: 'pie',
                data: 
                {
                    labels: ['Ngeles', 'Kalues'],
                    datasets: [{
                        label: '# of Votes',
                        data: [<?= $numri - $kalues ?>, <?= $kalues ?>],
                        backgroundColor: 
                        [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: 
                        [
                            'rgba(255, 99, 132, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: 
                {
                    scales: 
                    {
                        yAxes: 
                        [{
                            ticks: 
                            {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        </script>

        <script>
            $(document).ready(function () 
            {
                $('#mungesat').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ],
                    "order": [[0, "desc"]],
                    "searching": true

                })
            });
            $(document).ready(function () 
            {
                $('#notat').DataTable({
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
            $("#piktura").hover(function ()
            {
                console.log("FEFEF");
                $(this).css("background-color", "#44999c");
            });
        </script>      
</body>
</html>
