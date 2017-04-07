<?php

define('ROOT_PATH', dirname(dirname(__FILE__)));

$sessionPath = ROOT_PATH . '/log/session';

$lastModify = 0;
$dstDir = '';
$dir = dir("$sessionPath");
while (($entry = $dir->read()) !== false) {
	if (strlen($entry) <= 2) {
		continue;
	}

	$randomSession = $sessionPath . '/' . $entry;
	$timestamp = filemtime($randomSession);

	if ($timestamp > $lastModify) {
		$lastModify = $timestamp;
		$dstDir = $randomSession;
	}
}
$dir->close();

if ($dstDir) {
	$qrFile = "$dstDir/qr.png";
	if (file_exists($qrFile)) {
		Header("Content-type: image/png");
		header('Content-Length: '.filesize($qrFile));
		readfile($qrFile);
	} else {
		echo "welcome, please start sevice.";
	}
} else {
	echo "welcome, please start sevice.";
}
