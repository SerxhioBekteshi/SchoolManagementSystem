<?php 
    //require filet e nevojshme 
    require_once 'functions.php';
    include_once 'header.php';
    include_once 'sek_header.php';

    $pedagog_id = sanitizeString($_GET['prof_id']); //marrim id e pdagogut 
    $query_per_emrin = "SELECT emri, mbiemri FROM pedagog where pedagog_id='$pedagog_id'"; //marrim rreshtin nga query ku duam dhe cfr duam
    $result_per_emrin = queryMysql($query_per_emrin);
    $row = $result_per_emrin->fetch_assoc(); 
    $emri = $row['emri'] . ' ' . $row['mbiemri'];
?>
<head>
    <title>Pedagog</title>
    <link rel="stylesheet" type="text/css" href="sekretaria.css">
    <script type="text/javascript" src="student.js"></script>
</head>
<!-------------------------HEADER--------------------------------------->

<div class="content">
    <div class="container-fluid my-auto">
        <div class="row">
            <div class="col-lg-11">
                <br>
                <h4 class="menaxho">Informacione mbi <?= $emri ?> </h4>

                <?php
                    $query_per_notat = "SELECT nota from provim where pedagog_id = '$pedagog_id'"; //nga tabela provim marrim notat 
                    $result_per_notat = queryMysql($query_per_notat);
                    $kalues = 0;
                    $provime = 0;
                    $notat=array(); //i hedhim ne array
                    while ($row = $result_per_notat->fetch_assoc())  //bejme fetch nga databaza per te perdorur te dhenat 
                    {
                        if(!isset( $notat[$row['nota']]['nota'])) //nqs jo bosh
                        {
                            $notat[$row['nota']]['nota']=0; //notat ruajme perkatesisht 0 
                        }

                        if ($row['nota'] > 4) //nqs me e madhe se 4 eshte kalues 
                        {
                            $kalues++; //inkrementojme 
                        }
                        $provime++; //rrisim nr e provimeve 
                        $notat[$row['nota']]['nota']++; //inkementojme per noten tjeter
                    }

                    $query_per_mungesat = "SELECT prezent from mungesa where pedagog_id = '$pedagog_id'"; //query per prezencen e njeta
                    //logjike se te notat 
                    $result_per_mungesat = queryMysql($query_per_mungesat);
                    $seminare = 0;
                    $prezent = 0;
                    while ($row = $result_per_mungesat->fetch_assoc()) 
                    {
                        if ($row['prezent'] == 'po') 
                        {
                            $prezent++;
                        }
                        $seminare++;
                    }
                ?>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <canvas id="myChart" width="200" height="200"></canvas>
                        </div>

                        <div class="col-md-6">
                            <canvas id="myChart2" width="200" height="200"></canvas>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <canvas id="myChart3" width="200" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <br>

        </script>
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.css"/>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        
        <script type="text/javascript"
                src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.10.23/af-2.3.5/b-1.6.5/b-colvis-1.6.5/b-flash-1.6.5/b-html5-1.6.5/sl-1.3.1/datatables.min.js"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"
            integrity="sha512-C7hOmCgGzihKXzyPU/z4nv97W0d9bv4ALuuEbSf6hm93myico9qa0hv4dODThvCsqQUmKmLcJmlpRmCaApr83g=="
            crossorigin="anonymous"/> 

        <script 
            src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"
            integrity="sha512-hZf9Qhp3rlDJBvAKvmiG+goaaKRZA6LKUO35oK6EsM0/kjPK32Yw7URqrq3Q+Nvbbt8Usss+IekL7CRn83dYmw=="
            crossorigin="anonymous">
        </script>


    <script> //validimet perkatese 
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Ngeles', 'Kalues'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?= $provime - $kalues ?>, <?= $kalues ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(0, 100, 35, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(0, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctx2 = document.getElementById('myChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: ['Mungesa', 'Prezenca'],
                datasets: [{
                    label: '# of Votes',
                    data: [<?= $seminare - $prezent ?>, <?= $prezent ?>],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(0, 100, 35, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(0, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>
    </body>
    </html>