<?php
session_start();
if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if($id){
    // if you want to delete materials too, you can run DELETE FROM materials WHERE seller_id=$id
    $conn->query("DELETE FROM sellers WHERE seller_id=$id");
}
header("Location: view_sellers.php");
exit();
