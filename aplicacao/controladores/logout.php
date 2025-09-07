<?php
session_start();
session_destroy();
header("location: ../visoes/login.php");
exit;
