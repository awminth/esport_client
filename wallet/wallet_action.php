<?php 

include("../config.php");

$action = $_POST["action"];
$userid = $_SESSION["esportclient_userid"] ?? "";
$username = $_SESSION["esportclient_username"] ?? "";

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
    $chk_transactionno = GetString("SELECT AID FROM tblbalancein WHERE PrepaidStatus='success' AND TransitionCode = ?", [$transactionno]);
    if($chk_transactionno > 0){
        echo 2;
    }else{
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
    $chk_transactionno = GetString("SELECT AID FROM tblbalancein WHERE PrepaidStatus='success' AND TransitionCode = ?", [$transactionno]);
    if($chk_transactionno > 0){
        echo 2;
    }else{
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
}

//withdraw check
if($action == "withdrawcheck"){
    $chksbo_amt = 0;
    $chkibet_amt = 0;
    $totalamt = 0;
    $sqlchk_one = "select Amount,Date(DateTime) as dt from tblbalancein where PlayerID = '{$userid}' and 
    BonusStatus = 'yes' and WithdrawCheck = 'no' order by AID desc";
    $resone = mysqli_query($con, $sqlchk_one);
    if(mysqli_num_rows($resone) > 0){
        $bonusamount = 0;
        $dt = "";
        while($rowone = mysqli_fetch_assoc($resone)){
            $bonusamount += $rowone["Amount"];
            $dt = $rowone["dt"];
        }
        $chksbo_amt = GetInt("select sum(Amount) from tbldeduct where UserName = ? and 
        Date(BetTime) >= ? and CancelStatus = 'no'", [$username , $dt]);
        $usernameone = "ismmc1".$username;
        $chkibet_amt = GetInt("select sum(BetAmt) from tblibetfetch where UserName = ? and 
        Date(LastModified) >= ? and WinLoseStatus = 'P'", [$usernameone , $dt]);
        $totalamt = $chksbo_amt + $chkibet_amt;
        if($totalamt >= $bonusamount){
            echo 1;
        }
        else{
            echo 0;
        }
    }
    else{
        echo 2;
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

// transfer game to main (or) main to game
if($action == "transfer_wallet"){
    $result = $_POST["result"];
    $transferAmount = $_POST["transferAmount"];
    $playerid = $_SESSION["esportclient_userid"] ?? null;
    $playername = $_SESSION["esportclient_username"] ?? null;
    $serial = date("Ymd-His");
    // transfer main wallet to ibet789 game wallet
    if($result != "mainToGame"){
        $transferAmount = -$transferAmount;
    }

    //send withdraw API to ibet
    // For Transfer
    $transfer = callIbetAPI("http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/TransferFundWithRef", [
        "secret" => $secretID,
        "agent" => $agent,
        "userName" => $playername,
        "serial" => $serial,
        "amount" => $transferAmount
    ]);

    if ($transfer['errorCode'] === "") {
        // For Verify
        $verify = callIbetAPI("http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/VerifyDepositWithdraw", [
            "serial" => $serial,
            "secret" => $secretID,
            "agent" => $agent
        ]);

        if ($verify['errorCode'] === "") {
            mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
            mysqli_begin_transaction($con);
            try{
                $sql = "UPDATE tblbalancein SET PrepaidStatus='success' WHERE AID = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("i", $aid);
                if($stmt->execute()){
                    // get player current balance 
                    $current_balance = GetInt("SELECT Balance FROM tblplayer WHERE UserName = ? FOR UPDATE", [$playername]);
                    $final_balance = $current_balance - abs($transferAmount);
                    if($result != "mainToGame"){
                        $final_balance = $current_balance + abs($transferAmount);
                    }
                    // update player balance
                    $sql2 = "UPDATE tblplayer SET Balance = ? WHERE UserName = ?";
                    $stmt2 = $con->prepare($sql2);
                    $stmt2->bind_param("is", $final_balance, $playername);
                    $stmt2->execute();

                    // save log
                    save_log($playername." သည် [Amt : ".$transferAmount."] အား Wallet သို့ ".$result." Transfer လုပ်သွားသည်။");

                    mysqli_commit($con);
                    echo 1;
                }else{
                    mysqli_rollback($con);
                    error_log("Update data error in transfer main to game ".$stmt->error."\n", 3, root."wallet/my_log_file.log");
                    echo 0;
                }
            }catch (mysqli_sql_exception $e) {
                // Rollback on any error
                mysqli_rollback($con);
                error_log("Database error in transfer main to game, " . $e->getMessage(), 3, root."wallet/my_log_file.log");
                echo 0;
            } catch (Exception $e) {
                // Rollback on any other error
                mysqli_rollback($con);
                error_log("External error in transfer main to game, " . $e->getMessage(), 3, root."wallet/my_log_file.log");
                echo 0;
            }
        }else{
            echo "Transfer API error : " .$verify['errorCode']. " for " . $ibet_errorlist[$verify['errorCode']];
        }
    } else {
        echo "Transfer API error : " .$transfer['errorCode']. " for " . $ibet_errorlist[$transfer['errorCode']];
    }
}

?>