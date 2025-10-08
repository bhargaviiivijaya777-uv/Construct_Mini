<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id){
    $conn->query("DELETE FROM materials WHERE material_id=$id");
}
header("Location: view_materials.php");
exit();
