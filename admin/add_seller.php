<?php
session_start(); if(!isset($_SESSION['admin'])) header("Location: admin_login.php");
include('../db_connect.php');
$msg='';
if(isset($_POST['submit'])){
    $name=$conn->real_escape_string($_POST['seller_name']);
    $contact=$conn->real_escape_string($_POST['contact_number']);
    $address=$conn->real_escape_string($_POST['address']);
    if($conn->query("INSERT INTO sellers (seller_name, contact_number, address) VALUES ('$name','$contact','$address')")) $msg='Seller added';
    else $msg='Error: '.$conn->error;
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Add Seller</title><link rel="stylesheet" href="../css/style.css"></head><body>
<main class="container">
  <h1>Add Seller</h1><?php if($msg) echo "<p>$msg</p>"; ?>
  <form method="post">
    <input name="seller_name" placeholder="Name" required><br>
    <input name="contact_number" placeholder="Contact"><br>
    <input name="address" placeholder="Address"><br>
    <button name="submit" type="submit">Add Seller</button>
  </form>
  <p><a href="dashboard.php">Back</a></p>
</main>
</body></html>
