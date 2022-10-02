<!DOCTYPE html>
<?php
    require_once 'header.php';
    if ($_SESSION['roli'] != 'student')
        exit;
    require_once 'functions.php';
        $student_id=$_SESSION['student_id'];
    //print_array($tedhenat);exit;


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

    $queryklase_lendeve = "SELECT * FROM klase_lende";
    $result_klase_lendeve = queryMysql($queryklase_lendeve);
    $klase_lende = array();

    while ($row = $result_klase_lendeve->fetch_assoc()) 
    {
        $klase_lende[$row['klase_lende_id']]['klase_lende_id'] = $row['klase_lende_id'];
        $klase_lende[$row['klase_lende_id']]['kredite'] = $row['kredite'];
        $klase_lende[$row['klase_lende_id']]['semestri'] = $row['semestri'];
        $klase_lende[$row['klase_lende_id']]['lenda_id'] = $row['lenda_id'];
    }


    
    // if(isset($_POST['permireso']))
    // {
    //     $klase_lende_id=sanitizeString($_POST['klase_lende_id']);
    //     $student_id=sanitizeString($_POST['student_id']);

    //     $query_per_permiresim="UPDATE fitues_provimi SET perfundoi='jo' where student_id='$student_id' and klase_lende_id='$klase_lende_id'";
    //     $resultpermiresim=queryMysql($query_per_permiresim);
    //     if($query_per_permiresim) 
    //     {
    //         echo "GABIMMMM";
    //     }
    // }

    function mesatarja($notat, $numri)
    {
        $shuma = 0;
        foreach ($notat as $nota) 
        {
            $shuma += $nota;
        }
        return $shuma / $numri;
    }

    $randstr = substr(md5(rand()), 0, 7);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student</title>
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

</head>
<body>
    <input type="checkbox" id="check" name="">
    <!-------------------------HEADER--------------------------------------->
    <header>
        <label for="check">
            <i class="fa fa-bars" id="sidebar_btn"></i>
        </label>
        <div class="left_area">
            <h4> S<span>MA </span></h4>
        </div>
        <div class="right_area">
            <a href="logout.php" class="logout_btn">Logout </a>
        </div>
    </header>
    <header>
    <nav class="mb-1 navbar navbar-expand-lg navbar navbar-dark bg-dark " style="height: 65px">
        <a class="navbar-brand text-white" href="shfaqInfo.php"><strong>S<span style="color:#D31A38">MA</span></strong></a>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto"></ul>
            <div>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log out </a>
            </div>
    </nav>
</header>

<!-------------------------SIDEBAR-i--------------------->
<div class="sidebar">
    <div class="profile_info">
    <a href="stud_header.php" id = "piktura" style= "text-align:center"><img src="studenti.png" class="std"> </a> 
            <h5><i>Student</i></h5>
    </div>
    <a href="ndryshoPS.php"><i class="fa fa-cog" aria-hidden="true"></i><span>Ndrysho Profilin</span></a>
    <a href="shihnotat.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Shih notat</span></a>
    <!-- <a href="aplikimet.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i><span>Apliko</span></a> -->

</div>
<div class="content">
    <div class="permbajtja">
        <div class="content" style="margin:auto;width: 40%">
            <h2> Notat</h2><br>
            <table id="notat_stud" border="1">
                <thead>
                <th>Lenda</th>
                <th>Semestri</th>
                <th>Nota</th>
                </thead>
                <?php
                $query_notat = "SELECT * FROM provim where studenti_id='$student_id'";
                $result_notat = queryMysql($query_notat);

                $provimet = array();
                while ($row = $result_notat->fetch_assoc()) 
                {

                    if (!isset($provimet[$row['klase_lende_id']]['kredite'])) 
                    {
                        $provimet[$row['klase_lende_id']]['kredite'] = 0;
                    }
                    $provimet[$row['klase_lende_id']]['student_id'] = $student_id;
                    $provimet[$row['klase_lende_id']]['kredite'] = $klase_lende[$row['klase_lende_id']]['kredite'];
                    $provimet[$row['klase_lende_id']]['titulli_lendes'] = $lendet[$klase_lende[$row['klase_lende_id']]['lenda_id']]['lenda'];
                    $provimet[$row['klase_lende_id']]['nota'] = $row['nota'];

                    if ($klase_lende[$row['klase_lende_id']]['semestri'] < 3) 
                    {
                        $provimet[$row['klase_lende_id']]['semestri'] = 'Viti i pare: Semestri ' . $klase_lende[$row['klase_lende_id']]['semestri'];
                    } 
                    else if ($klase_lende[$row['klase_lende_id']]['semestri'] > 4) 
                    {
                        $provimet[$row['klase_lende_id']]['semestri'] = 'Viti i trete: Semestri ' . ($klase_lende[$row['klase_lende_id']]['semestri'] - 4);
                    } 
                    else 
                    {
                        $provimet[$row['klase_lende_id']]['semestri'] = 'Viti i dyte: Semestri ' . ($klase_lende[$row['klase_lende_id']]['semestri'] - 2);
                    }

                }

                //llogaritja e notave si mesatare te ponderuar 
                $notat = array();
                foreach ($provimet as $stud_id_key => $nota_info_value)
                {
                    if (!isset($notat['piket'])) 
                    {
                        $notat['piket'] = 0;
                    }
                    if (!isset($notat['kredite'])) 
                    {
                        $notat['kredite'] = 0;
                    }
                    $notat['piket'] += $nota_info_value['kredite'] * $nota_info_value['nota'];
                    $notat['kredite'] += $nota_info_value['kredite'];
                }

                foreach ($provimet as $klase_lende => $nota_info_value) 
                {
                    if ($klase_lende == 'mesatarja') 
                    {
                        continue;
                    }
                    ?>
                    <tr>
                        <td><?= $nota_info_value['titulli_lendes'] ?></td>
                        <td><?= $nota_info_value['semestri'] ?></td>
                        <td><?= $nota_info_value['nota'] ?></td>
                         <td>
                            <form method="POST" action="shihnotat.php">
                                <input type="hidden" value="<?= $klase_lende ?>" name="klase_lende_id">
                                <input type="hidden" value="<?= $nota_info_value['student_id'] ?>" name="student_id">
                                <!-- <input type="submit" value="Permireso" name="permireso"> -->
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tfoot>
                <th colspan="4">Mesatarja: <?= $notat['piket'] / $notat['kredite'] ?> </th>

                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- function javascript per te bere te munduar qe te dhenat tabelare ta shkarkohet si dokument perkatesisht me butonat -->
    <script>  
        $(document).ready(function () 
        {
            $('#notat_stud').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                "order": [[0, "desc"]],
                "searching": true
            })
        });
        $("#piktura").hover(function ()
        {
            console.log("FEFEF");
            $(this).css("background-color", "#44999c");
        });
    </script>
</body>
</html>