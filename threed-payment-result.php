<?php include 'views/shared/_header.php';

$_POST;

$mdStatus = $_POST["mdstatus"];
$errmsg = $_POST["errmsg"];
$mderrormessage = $_POST["mderrormessage"];
$response = $_POST["response"];
$txntype = $_POST["txntype"];
$txnamount = $_POST["txnamount"];
$txninstallmentcount = $_POST["txninstallmentcount"];
$oid = $_POST["oid"];
$clientid = $_POST["clientid"];

print "Bankadan dönen cevap:" . json_encode($_POST);

?>



<?php include 'views/shared/_footer.php'; ?>