<!DOCTYPE html>
<?php
        include_once 'header.php';
        include_once 'sek_header.php';

        /**
         * Mbushja e arrayt me klasat e studenteve
         */
        $student_klase = array();
        $klasat_e_studenteve_query = "SELECT * FROM student_klase";
        $result_klaset = mysqli_query($connection, $klasat_e_studenteve_query);
        while ($row = mysqli_fetch_assoc($result_klaset)) 
        {
                $student_klase[$row['student_klase_id']]['id'] = $row['student_klase_id'];
                $student_klase[$row['student_klase_id']]['klasa'] = $row['niveli'] . ':' . $row['dega'] . ' ' . $row['viti'] . ' ' . $row['grupi'];
        }

        /**
         * Mbushja e arrayt me student
         */
        $student = array();
        $student_query = "SELECT student_id,emer_mbiemer,student_email,atesia FROM student";
        $result_student = mysqli_query($connection, $student_query);
        while ($row = mysqli_fetch_assoc($result_student)) 
        {
                $student[$row['student_id']]['id'] = $row['student_id'];
                $student[$row['student_id']]['email'] = $row['student_email'];
                $student[$row['student_id']]['emer_mbiemer'] = $row['emer_mbiemer'];
                $student[$row['student_id']]['atesia'] = $row['atesia'];
        }
?>

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
</head>
<body>

        <script
                src="https://code.jquery.com/jquery-3.5.1.min.js"
                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
                crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
                integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
                crossorigin="anonymous">
        </script>

        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
                integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
                crossorigin="anonymous">
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

        <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

</body>

</html>