<?php
session_start();
$_SESSION['test'] = 'hello redis';
echo "Session started";
