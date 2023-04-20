<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//$restart_result = `sudo -S systemctl restart nginx`;
//echo $restart_result;
echo "Restarting nginx\n";

// Restart 
$cmd = "sudo docker exec reverse-proxy nginx -s reload";

$output = array();
$status = -1;

// Execute the Certbot command
exec($cmd, $output, $status);
echo implode("\n", $output);

// Check the output and status of the command
if ($status === 0) {
    echo "Nginx restart: command executed successfully.\n";
    echo implode("\n", $output);
} else {
    echo "Nginx restart:  executing command failed.\n";
    echo implode("\n", $output);
}

?>
