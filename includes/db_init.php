<?php
	if(session_status() !== PHP_SESSION_ACTIVE) {session_start();}

	$db["host"] = "localhost";
	$db["name"] = "cocktails";
	
	
	$db["user"] = "root";
	$db["password"] = "";

	