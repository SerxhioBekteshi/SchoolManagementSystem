<?php
include_once 'functions.php';
require_once 'header.php';
include_once 'prof_header.php';
$emaili = $_SESSION['user'];
$mesues_id = $_SESSION['mesues_id'];
$student_klase_id = $_SESSION['student_klas_selector'];
$lenda_id = $_SESSION['lenda'];

function mesatarja($notat, $numri){
    $shuma=0;
    foreach ($notat as $nota){
        $shuma+=$nota;
    }
    return $shuma/$numri;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Pedagog | Sekretaria Mesimore</title>
    <link rel="stylesheet" type="text/css" href="sekretaria2.css">
    <link rel="stylesheet" type="text/css" href="student.js">
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


<style type="text/css">
  .navbar .kerkimi_navbar{
position: absolute; 
 left: 250px;
}
#check:checked~.navbar .kerkimi_navbar{
 position: absolute; 
 left: 135px;
}
</style>
<!-------------------------HEADER--------------------------------------->

<!------------------------------CONTENT------------------------------->
<div class="content">
<div class="container">
 <br><br>
    <h2> Te dhenat </h2><br>
<br><br>
        <table class="table table-hover">
            <thead class="table-dark">
            <tr>
            <th>Studenti</th>
            <th>Lenda</th>
            <th>Klasa</th>
            <th>Numri i seminareve</th>
            <th>Mungesat</th>
            <th>Raporti mungesa/seminare</th></tr>
            </thead>
            <?php
            $query_mungesat = "SELECT * FROM klase_lende inner join student_klase on student_klase.student_klase_id=klase_lende.student_klase_id inner join lenda on lenda.lenda_id = klase_lende.lenda_id inner join mungesa on mungesa.klase_lende_id =klase_lende.klase_lende_id inner join student on mungesa.student_id=student.student_id where mungesa.mesues_id = '$mesues_id' and klase_lende.seminar_leksion ='s'  ";
            $result = queryMysql($query_mungesat);
            $tedhenat = array();
            while ($row = $result->fetch_assoc()) {
                if (!isset($tedhenat[$row['student_id']]['mungesa'])) {
                    $tedhenat[$row['student_id']]['mungesa'] = 0;
                }
                if (!isset($tedhenat[$row['student_id']]['seminare'])) {
                    $tedhenat[$row['student_id']]['seminare'] = 0;
                }

                $tedhenat[$row['student_id']]['student_id'] = $row['student_id'];
                $tedhenat[$row['student_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
                $tedhenat[$row['student_id']]['klase_lende_id'] = $row['klase_lende_id'];
                $tedhenat[$row['student_id']]['titulli_lendes'] = $row['titulli_lendes'];
                $tedhenat['titulli_lendes'] = $row['titulli_lendes'];
                $tedhenat[$row['student_id']]['klasa'] = $row['niveli'] . ":" . $row['dega'] . " " . $row['viti'] . " " . $row['grupi'];
                if ($row['prezent'] == 'jo') {
                    $tedhenat[$row['student_id']]['mungesa']++;
                }
                $tedhenat[$row['student_id']]['seminare']++;

            }
            foreach ($tedhenat as $stud_id_key => $mungesa_info_value) {
                if ($stud_id_key == 'titulli_lendes') {
                    continue;
                }
                ?>
                <tr>
                    <td><?= $mungesa_info_value['emer_mbiemer'] ?></td>
                    <td><?= $mungesa_info_value['titulli_lendes'] ?></td>
                    <td><?= $mungesa_info_value['klasa'] ?></td>
                    <td><?= $mungesa_info_value['seminare'] ?></td>
                    <td><?= $mungesa_info_value['mungesa'] ?></td>
                    <td><?php echo (($mungesa_info_value['mungesa'] / $mungesa_info_value['seminare']) * 100) . '%'; ?></td>
                </tr>
                <?php
            }
            ?>
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
        $query_notat = "SELECT * FROM klase_lende inner join student_klase on student_klase.student_klase_id=klase_lende.student_klase_id
inner join lenda on lenda.lenda_id=klase_lende.lenda_id 
inner join provim on  klase_lende.mesues_id =provim.mesuesi_id and provim.lenda_id=lenda.lenda_id and klase_lende.klase_lende_id =provim.klase_lende_id 
inner join student on student.student_id=provim.studenti_id  
where provim.mesuesi_id  = '$mesues_id' ";
        $result_notat = queryMysql($query_notat);

        $provimet = array();
        while ($row = $result_notat->fetch_assoc()) {
//            print_array($row);
            if (!isset($provimet[$row['student_id']]['notatotale'])) {
                $provimet[$row['student_id']]['notatotale'] = 0;
            }
            if (!isset( $provimet[$row['student_id']]['nxenesit'])) {
                $provimet[$row['student_id']]['nxenesit'] = 0;
            }

            $provimet[$row['student_id']]['student_id'] = $row['student_id'];
            $provimet[$row['student_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
            $provimet[$row['student_id']]['klase_lende_id'] = $row['klase_lende_id'];
            $provimet[$row['student_id']]['titulli_lendes'] = $row['titulli_lendes'];
            $provimet[$row['student_id']]['nota'] = $row['nota'];
            $provimet[$row['student_id']]['data'] = $row['viti_provimit'];
            $provimet[$row['student_id']]['klasa'] = $row['niveli'] . ":" . $row['dega'] . " " . $row['viti'] . " " . $row['grupi'];


        }
$notat=array();
        foreach ($provimet as $stud_id_key => $nota_info_value) {
            $notat[]=$nota_info_value['nota'];
        }
        foreach ($provimet as $stud_id_key => $nota_info_value) {
            if ($stud_id_key == 'mesatarja') {
                continue;
            }
            ?>
            <tr>
                <td><?= $nota_info_value['emer_mbiemer'] ?></td>
                <td><?= $nota_info_value['titulli_lendes'] ?></td>
                <td><?= $nota_info_value['klasa'] ?></td>
                <td><?= $nota_info_value['nota'] ?></td>
            </tr>
            <?php
        }
        ?>
        <tfoot>
        <th colspan="4">Mesatarja: <?= mesatarja($notat,count($notat)) ?> </th>
        </tfoot>
    </table>

</div></div>
<script>
    $(document).ready(function () {
        $('#mungesat').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf'
            ],
            "order": [[0, "desc"]],
            "searching": true

        })
    });
    $(document).ready(function () {
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
</body>
</html>
