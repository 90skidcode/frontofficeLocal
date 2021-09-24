
<?php
date_default_timezone_set("Asia/Kolkata"); 

if($_SERVER['SERVER_NAME'] == "localhost"){//Demo Ips
define('HOSTNAME','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME', 'glowmedi_frontoffice');
} else {
define('HOSTNAME','localhost');
define('DB_USERNAME','glowmedi_frontoffice');
define('DB_PASSWORD','LuC~=zk&Jf6y');
define('DB_NAME', 'glowmedi_frontoffice');
}
$conn = mysqli_connect(HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME) or die ("error");
// Check connection
if(mysqli_connect_errno($conn)){
    ?><script>
    var error = "Failed to connect MySQL: " .mysqli_connect_error();
   </script><?php
}	
?>