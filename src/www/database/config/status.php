<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//$restart_result = `sudo -S systemctl restart nginx`;
//echo $restart_result;
// GET status
$cmd = "sudo docker ps | grep reverse-proxy";

$output = array();
$status = -1;

// Execute the Certbot command
exec($cmd, $output, $status);
echo "<pre>" . implode("\n", $output) . " " . $status;

// Check the output and status of the command
if ($status === 0) {
    echo "Nginx status: command executed successfully.\n";
    echo implode("\n", $output);
} else {
    echo "Nginx status: executing command failed.\n";
    echo implode("\n", $output);
}

?>
