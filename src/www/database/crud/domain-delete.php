<?php
require_once('../db.php');

$db = new MyDB();

$id = $_GET['id'];
$sql = "DELETE FROM  `domain` WHERE `id`  =  $id ";

if ($db->exec($sql)) {
    $response = [
        'status' => 'ok',
        'success' => true,
        'message' => 'Record deleted successfully!'
    ];
    print_r(json_encode($response));
} else {
    $response = [
        'status' => 'ok',
        'success' => false,
        'message' => 'Record deleted failed!'
    ];
    print_r(json_encode($response));
}
?>