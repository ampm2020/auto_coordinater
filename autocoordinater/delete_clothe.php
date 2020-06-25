<?php
require('dbconnect.php');
$id = $_POST['clothe_id'];
$sql = $db->prepare('DELETE FROM clothes WHERE id=?');
$sql->bindparam(1, $id, PDO::PARAM_INT);
$sql->execute();

header("Location: closet.php");
exit();
