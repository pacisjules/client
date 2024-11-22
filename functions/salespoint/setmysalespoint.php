<?php
session_start();
$salespointid=$_POST['salespointid'];
$_SESSION['mysalepoint']=$salespointid;
echo 'Setted Succesfuly';
?>