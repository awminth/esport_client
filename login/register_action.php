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

    $data = callIbetAPI($url,$data);

    //ibet789
    $url2 = "http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/CreateAccount"; // Replace with your API URL


    $data2 = [
        "secret" => $secretID,
        "agent" => "ismmc1",
        "userName" => $username,
    ];

    $data2 = callIbetAPI($url2,$data2);

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

                    //update ibet member setting myanmar
                    $url3 =  "http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/UpdateMemberSettingsMyanmar";
                    $data3 = [
                        "secret" => $secretID,
                        "agent" => "ismmc1",
                        "userName" => $username,
                        "max1"=> 10000,
                        "lim1"=> 10000,
                        "lim2"=> 10000,
                        "lim7"=> 10000,
                        "isSuspended"=> false,
                        "comType"=> "A",
                        "com1"=> 0,
                        "com2"=> 0,
                        "com3"=> 0,
                        "com4"=> 0,
                        "status"=> "1",
                        "accType"=> "MY"
                    ];

                    $data3 = callIbetAPI($url3,$data3);
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