<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

//define('SOURCE_CSV', 'BE07001627317466EUR_020113-090413.CSV');
define('SWIFT', 'GEBABEBB');
define('EOL', "\r\n");

require('classes/CsvParser.php');
require('classes/MT940Generator.php');
require('classes/Transaction.php');

$allowedExts = array("csv", "txt");
$extension = strtolower(substr($_FILES["file"]["name"], -3));
if ((($_FILES["file"]["type"] == "text/plain")
	|| ($_FILES["file"]["type"] == "text/txt")
	|| ($_FILES["file"]["type"] == "text/csv"))
	&& ($_FILES["file"]["size"] < 2000000)
	&& in_array($extension, $allowedExts)) {
  
		if ($_FILES["file"]["error"] > 0) {
			echo "Error: " . $_FILES["file"]["error"] . "<br>";
		} else {
			//echo "Upload: " . $_FILES["file"]["name"] . "<br>";
			//echo "Type: " . $_FILES["file"]["type"] . "<br>";
			//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
			//echo "Stored in: " . $_FILES["file"]["tmp_name"];
			
			$mt940 = '';

			$csvParser = new CsvParser();
			$transactions = $csvParser->parse($_FILES["file"]["tmp_name"]);
			
			if($transactions) {
				$mt940Generator = new MT940Generator();
				$mt940 = $mt940Generator->generate($transactions);
				
				header('Content-disposition: attachment; filename=mutaties.940');
				header('Content-type: text/plain');
				
				echo $mt940;
				exit();
			}	
		}
} else {
	echo "Invalid file";
	var_dump($_FILES);
}
	