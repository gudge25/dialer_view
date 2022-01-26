<?php

# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}
# Класс конфига 
$config = new config;

# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$pref = $config->BasePrefix;



// 0= в очереди  1- недоступен  2- прослушал  3- обился

$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$pref = $config->BasePrefix;

$result =	$db->Query("SELECT phone FROM db_phone where  res!='2' and  res!='1' ORDER BY status ASC, npp ASC LIMIT 1");

if (!$result) {
    echo "Ошибка DB, запрос не удался\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}

while ($row = $db->FetchArray()) {
//    print_r ($row);
//    echo $row['phone'];
echo $row['phone'];


// Replace with your port if not using the default.
// If unsure check /etc/asterisk/manager.conf under [general];
$port = 5038;

// Replace with your username. You can find it in /etc/asterisk/manager.conf.
// If unsure look for a user with "originate" permissions, or create one as
// shown at http://www.voip-info.org/wiki/view/Asterisk+config+manager.conf.
$username = "dial";

// Replace with your password (refered to as "secret" in /etc/asterisk/manager.conf)
$password = "jivnuinbruin";

// Internal phone line to call from
$internalPhoneline = $row['phone'];

// Context for outbound calls. See /etc/asterisk/extensions.conf if unsure.
$context = "autoinformer";

//Updarte ROW
// $updatedata=mysql_query("UPDATE db_phone SET status = status+1 WHERE phone =$internalPhoneline");
//UPDATE db_phone SET status = status+1 WHERE phone =$internalPhoneline

$updatedata = $db->Query("UPDATE db_phone SET status = status+1 WHERE phone =$internalPhoneline");

if (!$updatedata) {
    echo "Ошибка DB, запрос не удался\n";
    echo 'MySQL Error: ' . mysql_error();
    exit;
}




$socket = stream_socket_client("tcp://localhost:$port");
if($socket)
{
    echo "Connected to socket, sending authentication request.\n";

    // Prepare authentication request
    $authenticationRequest = "Action: Login\r\n";
    $authenticationRequest .= "Username: $username\r\n";
    $authenticationRequest .= "Secret: $password\r\n";
    $authenticationRequest .= "Events: off\r\n\r\n";

    // Send authentication request
    $authenticate = stream_socket_sendto($socket, $authenticationRequest);
    if($authenticate > 0)
    {
        // Wait for server response
        usleep(200000);

        // Read server response
        $authenticateResponse = fread($socket, 4096);

        // Check if authentication was successful
        if(strpos($authenticateResponse, 'Success') !== false)
        {
            echo "Authenticated to Asterisk Manager Inteface. Initiating call.\n";

            // Prepare originate request
            $originateRequest = "Action: Originate\r\n";
            $originateRequest .= "Channel: Local/$internalPhoneline@dialout\r\n";
            $originateRequest .= "Callerid: 220\r\n";
            $originateRequest .= "Exten: s\r\n";
            $originateRequest .= "Context: $context\r\n";
            $originateRequest .= "Priority: 1\r\n";
            $originateRequest .= "Variable: var1=$internalPhoneline\r\n";
            $originateRequest .= "Async: yes\r\n\r\n";
            
            // Send originate request
            $originate = stream_socket_sendto($socket, $originateRequest);
            if($originate > 0)
            {
                // Wait for server response
                usleep(200000);

                // Read server response
                $originateResponse = fread($socket, 4096);

                // Check if originate was successful
                if(strpos($originateResponse, 'Success') !== false)
                {
                    echo "Call initiated, dialing.";
                } else {
                    echo "Could not initiate call.\n";
                }
            } else {
                echo "Could not write call initiation request to socket.\n";
            }
        } else {
            echo "Could not authenticate to Asterisk Manager Interface.\n";
        }
    } else {
        echo "Could not write authentication request to socket.\n";
    }
} else {
    echo "Unable to connect to socket.";
}

//mysql_free_result($result);
}
?>
