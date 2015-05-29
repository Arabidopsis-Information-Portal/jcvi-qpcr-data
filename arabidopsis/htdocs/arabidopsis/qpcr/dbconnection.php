<?php	
	$username="access";
	$password="access";

//if (strpos("www-devel.tigr.org",$_server[HTTP_REFERER])==0) {
//$hostName="mysql-dmz";  //external server }
//else { $hostName="mysql-dmz"; } 

# External, public database server
$hostName="mysql-dmz-pro";

# Internal, development database server
#$hostName="mysql";

function showerror()
{
   if (mysql_error())
      die("Error " . mysql_errno() . " : " . mysql_error());
   else
      die("Could not connect to the DBMS");
}

// Secure the user data by escaping characters 
// and shortening the input string
function clean($input, $maxlength)
{
  $input = substr($input, 0, $maxlength);
  $input = EscapeShellCmd($input);
  return ($input);
}


  if (!($connection =  @ mysql_pconnect($hostName, 
                                    $username,
                                    $password)))
     showerror();

?>
