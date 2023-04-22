<?php
ob_implicit_flush(true);
ob_end_flush();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../db.php');

//$_GET['ip'] = "1.1.1.1";

$ip = $_GET["ip"];

// echo $ip;
$cookie_name = "ip";
setcookie($cookie_name, $ip, time() + (86400 * 100), "/");
// function start($argv)
// {
$db = new MyDB();

$db->exec('CREATE TABLE IF NOT EXISTS domain (id INTEGER PRIMARY KEY, name STRING, status STRING, date STRING);');
// $db->exec("INSERT INTO domain (name, status, date) VALUES ('This is a test', '123', '123')");

$sql = "SELECT * FROM `domain`";
// $db->exec("INSERT INTO domain (bar) VALUES ('This is a test')");

$result = $db->query($sql);
$data = [];
while ($fetch = $result->fetchArray()) {
	$data[] = $fetch;
}
// echo "result";
// var_dump($result->fetchArray());

// `notepad`;

if (strlen($ip) == 0) {
	die("destination ip NOT set php start.php 1.2.3.4\n");
}

// create directories from domainlist.txt
// $domains = $data;
$serverIP = trim(`curl https://ipinfo.io/ip`);
$nginx_path = "/etc/nginx/sites-enabled/reverse-proxy.conf";

$vhost_header = file_get_contents("/nginx-templates/vhost-header.txt");
$vhost = str_replace("DESTINATIONIP", $ip, $vhost_header);
$goodCount = 0;
$out = "";
$base = "/etc/nginx/conf.d";
$certs = "/certs";

foreach ($data as $fetch) {
	// var_dump($fetch);
	$d = $fetch["name"];
	// echo $d . "testing";

	// check if domains are pointed to server IP

	// echo "$d\n";

	if (gethostbyname($d) == $serverIP) {

		//@mkdir("/var/www/" . $d);
		// generate certificate
		//
		// $cmd = "sudo certbot certonly -n --agree-tos --no-redirect --nginx --register-unsafely-without-email -d $d -w /var/www/$d\n";
		//$cmd = "sudo -S /usr/bin/certbot certonly -n --agree-tos --no-redirect --nginx --register-unsafely-without-email -d $d -w /var/www/$d --config-dir $certs/certificates --work-dir $certs/certificates --logs-dir $certs/certificates";
		$cmd = "/usr/bin/certbot certonly -n --agree-tos --no-redirect --webroot --register-unsafely-without-email -d $d -w /var/www/html --config-dir $certs/certificates --work-dir $certs/certificates --logs-dir $certs/certificates";

		$output = array();
		$status = -1;

		// Execute the Certbot command
		exec($cmd, $output, $status);

		// Check if $certs/certificates/live/servicecuaea.com/fullchain.pem and $certs/certificates/servicecuaea.com/fullchain.pem exist
		// /var/www/nginxConfig/certificates/live/globalthanakha.com/fullchain.pem
		$f1 = "$certs/certificates/live/$d/fullchain.pem";
		$f2 = "$certs/certificates/live/$d/privkey.pem";
		$exist_pem = is_link($f1) && is_link($f2);
		$exist_str = $exist_pem ? "exist" : "not exist\n$f1\n$f2";
		
		echo "\nstatus: $status exists: ". var_export($exist_pem, true) . "\n";
		
		if ($status != -1 && $exist_pem) {

			// add domain config to $vhost
			//
			$tmpl = file_get_contents("/nginx-templates/vhost-template.txt");
			$tmpl = str_replace("DOMAIN", $d, $tmpl);
			$tmpl = str_replace("DESTINATIONIP", $ip, $tmpl);

			$vhost .= "\n\n" . $tmpl;
			$goodCount++;

			$out .= $d . "\n";
			// file_put_contents("/etc/nginx/sites-enabled/$d.conf", $tmpl);
			$tmpl_file = "$base/$d.conf";
			file_put_contents($tmpl_file, $tmpl);
			echo $tmpl_file. "\n";
			echo "Domain $d is successful\n" . implode("\n", $output) . "";
		} else {
			echo "Domain $d is failed\n$cmd\n$exist_str\n" . implode("\n", $output) . "\n";
		}
	} else {
		echo "Domain $d is not pointed to $serverIP\n";
	}
	

}
echo "End!\n";

if ($goodCount > 0) {
	// save nginx config
	//file_put_contents($nginx_path, $vhost);
	echo "Testing configuration\n";
	// test & restart nginx
	//$test_result = `sudo -S /usr/sbin/nginx -t`;
	//echo $test_result;
	
	$cmd = "sudo docker exec reverse-proxy nginx -t 2>&1";
	$output = array();
	$status = -1;

// Execute the Certbot command
	exec($cmd, $output, $status);
	echo implode("\n", $output) . " " . $status;
	// `systemctl restart nginx`;
}
?>
