<?php
require_once('../db.php');

$db = new MyDB();
// var_dump($db);
$names = $_POST['names'];
$status = $_POST['status'];
$date = date("Y/m/d");
$result = true;
foreach ($names as &$name) {
    $sql = "INSERT INTO domain (name, status, date)
    SELECT '$name', '$status', '$date' WHERE NOT EXISTS(SELECT * FROM domain WHERE NAME='$name')";
    // $sql = "INSERT INTO domain (name, status, date) VALUES ('$name', '$status', '$date');";
    try {
        $db = new MyDB();
        $result = $result && $db->exec($sql);
    } catch (Exception $e) {

    }
    // var_dump($name);
}
// exit;
// echo $sql;
// exit;

if ($result) {
    $response = [
        'status' => 'ok',
        'success' => true,
        'message' => 'Record created successfully!'
    ];
    print_r(json_encode($response));
} else {
    $response = [
        'status' => 'ok',
        'success' => false,
        'message' => 'Record created failed!'
    ];
    print_r(json_encode($response));
}
?>