<?php

function doDB()
{
	global $mysqli;
	// Connect to the Server and select database

	$mysqli = mysqli_connect("localhost","root", "","test");

	if(mysql_errno())
	{
		printf("Connect Failed: %s\n",mysqli_connect_errno());
		exit();
	}

}

function emailChecker($email)
{
	global $mysqli, $check_res;
	// check that email is not already in the list

	$check_Sql = "select id from subscribers where email = '".$email."'";
	$check_res = mysqli_query($mysqli,$check_Sql) or die(mysqli_error($mysqli));
}

//doDB();
?>