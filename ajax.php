<?php

$host='localhost';
$datebase='sma-app';
$user='root';
$password='';
$con = mysqli_connect($host, $user, $password, $datebase);

if ($_POST['action'] == "delete_klase") {

    $id = mysqli_real_escape_string($con,$_POST['id']);


    $check_if_exist_query = "SELECT * FROM klasa WHERE klasa_id='$id'";

    $result_if_exists_query = mysqli_query($con,$check_if_exist_query);
    if(!$result_if_exists_query){
        echo json_encode(array('status'=>'404', 'message'=>"Error ne databaze, kontaktoni me adminin"));
        exit;
    }

    if(mysqli_num_rows($result_if_exists_query)<1){
        echo json_encode(array('status'=>'404', 'message'=>"Klasa nuk ekziston"));
        exit;
    }


    $delete_user_query = "DELETE FROM klasa WHERE klasa_id='$id'";
    $result_delete_user = mysqli_query($con,$delete_user_query);
    if (!$result_delete_user) {
        echo json_encode(array('status'=>'404', 'message'=>"Error ne databaze, kontaktoni me adminin"));
        exit;
    }else{
        echo json_encode(array("status" => "200", "message" => "Klasa u fshi me suskess"));
        exit;
    }

}
?>