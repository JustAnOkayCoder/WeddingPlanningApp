<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
</head>
<body>

<?php


//needed this to get around my local host problem
function getIPAddress() {
    //is the ip shared 
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }
    // does it use a proxy
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        $ip = explode(',', $ip)[0]; // Use the first IP if there are multiple IPs
    }
    // is it a remote addrress 
    else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

$user_ip = getIPAddress();
//echo "User IP: " . $user_ip . "<br>";
//if i didnt add this section it would onlt ever show my IP and thats it 
if ($user_ip === '::1' || $user_ip === '127.0.0.1') {
    // if its me on this computer will use googles ip instead to show a differnt area 
    $user_ip = '8.8.8.8'; 
    //echo "Using test IP: " . $user_ip . "<br>";
}


if ($DBConnect == false) {
    die("Cannot connect: " . mysqli_connect_error());
} else {
    $TableName = "apitest";
    $fields = "status,message,country,countryCode,region,regionName,city,zip,lat,lon,timezone,isp,org,as,query";
    $ip_api_url = "";
    //echo "IP API URL: " . $ip_api_url . "<br>";

    $ip_info = json_decode(file_get_contents($ip_api_url), true);

    if ($ip_info && $ip_info['status'] == 'success') {
        // The data I want to capture on the visit
        $query = stripslashes($ip_info['query']);
        $status = stripslashes($ip_info['status']);
        $country = stripslashes($ip_info['country']);
        $countryCode = stripslashes($ip_info['countryCode']);
        $region = stripslashes($ip_info['region']);
        $regionName = stripslashes($ip_info['regionName']);
        $city = stripslashes($ip_info['city']);
        $zip = stripslashes($ip_info['zip']);
        $lat = stripslashes($ip_info['lat']);
        $lon = stripslashes($ip_info['lon']);
        $timezone = stripslashes($ip_info['timezone']);
        $isp = stripslashes($ip_info['isp']);
        $org = stripslashes($ip_info['org']);
        $as = stripslashes($ip_info['as']);
        
        // Add the information into the table
        $SQLstring = "INSERT INTO `$TableName` (`query`, `status`, `country`, `countryCode`, `region`, `regionName`, `city`, `zip`, `lat`, `lon`, `timezone`, `isp`, `org`, `as`) 
		VALUES ('$query', '$status', '$country', '$countryCode', '$region', '$regionName', '$city', '$zip', '$lat', '$lon', '$timezone', '$isp', '$org', '$as')";

        // see if itl print the string
       // print "getting the api data: " . $SQLstring . "<br>";

        // does the api even work
        if (mysqli_query($DBConnect, $SQLstring)) {
            //print "bout time it works <br>";
        } else {
            //print "Its a hunk of junk: " . mysqli_error($DBConnect) . "<br>";
        }

    } else {
        //print "It wont get the ip stuff: " . $ip_info['message'];
    }

    mysqli_close($DBConnect);
}

?>

</body>
</html>
