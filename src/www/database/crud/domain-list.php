<?php
require_once('../db.php');

$db = new MyDB();

$db->exec('CREATE TABLE IF NOT EXISTS domain (id INTEGER, name TEXT UNIQUE, status TEXT, date TEXT, PRIMARY KEY("id" AUTOINCREMENT));');
// $db->exec("INSERT INTO domain (name, status, date) VALUES ('This is a test', '123', '123')");

$sql = "SELECT * FROM `domain`";
// $db->exec("INSERT INTO domain (bar) VALUES ('This is a test')");

$result = $db->query($sql);
// echo "result";
// var_dump($result->fetchArray());
$data = [];
while ($fetch = $result->fetchArray()) {
    $fetch["ip"] = gethostbyname($fetch["name"]);
    $data[] = $fetch;
    // var_dump($fetch);
}
print_r(json_encode($data));
?>