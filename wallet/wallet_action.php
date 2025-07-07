<?php 

include("../config.php");

$action = $_POST["action"];

//topup
if ($action == "topupkpay") {
    $kpayname = $_POST["kpayname"];
    $kpayno = $_POST["kpayno"];
    $amount = $_POST["amount"];
    $transactionno = $_POST["transactionno"];
    $playerid = $_SESSION["esportclient_userid"];
    $todaydt = date("Y-m-d H:i:s");
    $paytype = "KBZ Pay";

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $sql = "INSERT INTO tblbalancein (PlayerID,Amount,TransitionCode,PayType,DateTime,KpayName,KpayNo) 
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("idsssss", $playerid, $amount, $transactionno, $paytype, $todaydt, $kpayname, $kpayno);
        if ($stmt->execute()) {
            save_log("Username ".$_SESSION['esportclient_username']." သည်Amount ".$amount." အား kpayဖြင့် topupလုပ်သွားသည်။");
            mysqli_commit($con);
            echo 1;
        }
        else {
            error_log("Topup Kpay error echo 0 in mainwallet_action.php".$stmt->error."\n", 3, root."wallet/my_log_file.log");
            mysqli_rollback($con);
            echo 0;
        }
    } 
    catch (mysqli_sql_exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

if ($action == "topupwave") {
    $wavename = $_POST["wavename"];
    $waveno = $_POST["waveno"];
    $amount = $_POST["amount"];
    $transactionno = $_POST["transactionno"];
    $playerid = $_SESSION["esportclient_userid"];
    $dt = date("Y-m-d H:i:s");
    $paytype = "Wave Pay";

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $sql = "INSERT INTO tblbalancein (PlayerID,Amount,TransitionCode,PayType,DateTime,KpayName,KpayNo) 
        VALUES (?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("idsssss", $playerid, $amount, $transactionno, $paytype, $dt, $wavename, $waveno);

        if ($stmt->execute()) {
            save_log("Username ".$_SESSION['esportclient_username']." သည် Amount ".$amount." အား wavemoney ဖြင့် topup လုပ်သွားသည်။");
            mysqli_commit($con);
            echo 1;
        }
        else {
            // if not enough balance
            mysqli_rollback($con);
            echo 0;
        }
    } 
    catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

//withdraw
if ($action == "withdrawkpay") {
    $kpayname = $_POST["kpayname"];
    $kpayno = $_POST["kpayno"];
    $amount = $_POST["amount"];
    $playerid = $_SESSION["esportclient_userid"];
    $dt = date("Y-m-d H:i:s");
    $paytype = "KBZ Pay";
    $prepaidstatus = "prepaid";
    $winlossstatus = "withdraw";

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $player_balance = GetInt("SELECT Balance FROM tblplayer WHERE AID = ? FOR UPDATE", 
                                            [$playerid]);
        if($amount > $player_balance){
            echo 2;
        }
        else{
            $sql = "INSERT INTO tblbalanceout (PlayerID,Amount,PayType,PrepaidStatus,WinLossStatus,
            DateTime,KpayName,KpayNo) 
            VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("idssssss", $playerid, $amount, $paytype, $prepaidstatus, $winlossstatus,
            $dt, $kpayname, $kpayno);
    
            if ($stmt->execute()) {
                $update_balance = $player_balance - $amount;
                $sql_playerupdate = "UPDATE tblplayer SET Balance = ? WHERE AID = ?";
                $stmt_update = $con->prepare($sql_playerupdate);
                $stmt_update->bind_param("di", $update_balance, $playerid);
                $stmt_update->execute();
                save_log("Username ".$_SESSION['esportclient_username']." သည်Amount ".$amount." အား kpayဖြင့် ငွေထုတ်သွားသည်။");
                mysqli_commit($con);
                echo 1;
            }
            else {
                // if not enough balance
                mysqli_rollback($con);
                echo 0;
            }
        }  
    } 
    catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

if ($action == "withdrawwave") {
    $wavename = $_POST["wavename"];
    $waveno = $_POST["waveno"];
    $amount = $_POST["amount"];
    $playerid = $_SESSION["esportclient_userid"];
    $dt = date("Y-m-d H:i:s");
    $paytype = "Wave Pay";
    $prepaidstatus = "prepaid";
    $winlossstatus = "withdraw";

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $player_balance = GetInt("SELECT Balance FROM tblplayer WHERE AID = ? FOR UPDATE", 
                                            [$playerid]);
        if($amount > $player_balance){
            echo 2;
        }
        else{
            $sql = "INSERT INTO tblbalanceout (PlayerID,Amount,PayType,PrepaidStatus,WinLossStatus,
            DateTime,KpayName,KpayNo) 
            VALUES (?,?,?,?,?,?,?,?)";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("idssssss", $playerid, $amount, $paytype, $prepaidstatus, $winlossstatus,
            $dt, $wavename, $waveno);
    
            if ($stmt->execute()) {
                $update_balance = $player_balance - $amount;
                $sql_playerupdate = "UPDATE tblplayer SET Balance = ? WHERE AID = ?";
                $stmt_update = $con->prepare($sql_playerupdate);
                $stmt_update->bind_param("di", $update_balance, $playerid);
                $stmt_update->execute();
                save_log("Username ".$_SESSION['esportclient_username']." သည်Amount ".$amount." အား wavemoneyဖြင့် ငွေထုတ်သွားသည်။");
                mysqli_commit($con);
                echo 1;
            }
            else {
                // if not enough balance
                mysqli_rollback($con);
                echo 0;
            }
        }  
    } 
    catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

?>