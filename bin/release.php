#!/usr/bin/env php
<?php

$version = "v1.2.0";
$message = "Added attachFromPath for sending mails with attachements";

file_put_contents("README.md", "\n* Version " . $version . ": " . $message, FILE_APPEND);

$res = shell_exec('git add .');
$res = shell_exec('git commit -m "' . $message . '"');
$res = shell_exec('git push');

$res = shell_exec('git tag -a ' . $version . ' -m "' . $message . '"');
$res = shell_exec('git push origin ' . $version);

$res = shell_exec('ssh svenvett@svenvett.myhostpoint.ch  "cd /home/svenvett/www/satis; bin/satis build satis.json"');
?>
