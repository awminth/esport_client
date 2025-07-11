<?php 

include("../config.php");
$action=$_POST["action"];

if($action=="register"){
    $usergp = "a";
    $serverid = date("YmdHis");
    $username=$_POST["username"];
    $password=$_POST["pwd"];
    $phoneno=$_POST["phoneno"];
    $email=$_POST["email"];
    $nrc=$_POST["nrc"];
    $agentid=$_POST["agentid"];
    $agentname=GetString("select UserName from tblagent where AID='{$agentid}'");
    $ibagent = "ismmc1";
    $displayname = $_POST["displayname"];
    $dt = (new DateTime())->format('Y-m-d H:i:s');
    //Send data to API
    $url = "https://ex-api-demo-yy.568win.com/web-root/restricted/player/register-player.aspx"; // Replace with your API URL

    $data = [
        "CompanyKey" => $companykey,
        "ServerId" => $serverid,
        "Username" => $username,
        "Agent" => $agentname,
        "UserGroup" => "a",
        "DisplayName" => $displayname,
    ];

    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    
    // Send JSON data
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    // Set the appropriate Content-Type for JSON
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    //for local xampp
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Only for dev
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Only for dev

    // Execute the request and get the response
    $response = curl_exec($ch);

    // Decode JSON
    $data = json_decode($response, true);

    // Close cURL session
    curl_close($ch);

    //ibet789
    $url2 = "http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/CreateAccount"; // Replace with your API URL


    $data2 = [
        "secret" => $secretID,
        "agent" => "ismmc1",
        "userName" => $username,
    ];

    // Initialize cURL session
    $ch2 = curl_init($url2);

    // Set cURL options
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_POST, true);
    
    // Send JSON data
    curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($data2));
    
    // Set the appropriate Content-Type for JSON
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json"
    ]);

    //for local xampp
    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); // Only for dev
    curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false); // Only for dev

    // Execute the request and get the response
    $response2 = curl_exec($ch2);

    // Decode JSON
    $data2 = json_decode($response2, true);

    // Close cURL session
    curl_close($ch2);

    // Set transaction isolation level and begin transaction
    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try{
        // Check for 'msg'
        if (isset($data['error']['msg'])) {
            if($data['error']['msg']=="No Error" && $data['error']['id']==0){
                //insert local database
                $sql = "insert into tblplayer (CompanyKey,ServerID,UserName,Password,PhoneNo,
                Email,NRC,AgentName,IbAgent,AgentID,UserGroup,DisplayName,DT,secretID) 
                values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $con->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Prepare failed" . $con -> error);
                }

                $stmt->bind_param("sssssssssissss",$companykey, $serverid, $username, $password, $phoneno,
                $email, $nrc, $agentname, $ibagent, $agentid, $usergp, $displayname, $dt, $secretID);

  

                if ($stmt->execute()) {
                    mysqli_commit($con);
                    echo 1;
                }
                else{
                    mysqli_rollback($con);
                    echo 0;
                }
            } 
            else{
                mysqli_rollback($con);
                echo "sbo " . $data['error']['msg'];
            }       
        } 
        else {
            mysqli_rollback($con);
            echo "sbo " . $data['error']['msg'];
        }  
    }
    catch(mysqli_sql_exception $e){
        mysqli_rollback($con);
        error_log("error in database".$e -> getMessage());
        echo 0;
    }
    catch(Exception $e){
        mysqli_rollback($con);
        error_log("error in system".$e -> getMessage());
        echo 0;
    } 
}

?>