<?php 

include("../config.php");
$action=$_POST["action"];

//topup history
if($action == "show_topup_data"){
    $userid = $_SESSION["esportclient_userid"];
    $entryvalue = $_POST["search_topup"];
    $todaydt = date("Y-m-d");
    $a = "";
    $datevalue = "";
    if($entryvalue == 2){
        $datevalue = "Last 7 Day";
        $todaydt = date("Y-m-d", strtotime("-7 days"));
        $a .= " and Date(DateTime) >= '$todaydt'";
    }
    else if($entryvalue == 3){
        $datevalue = "1 Month";
        $todaydt = date("Y-m-d", strtotime("-1 month"));
        $a .= " and Date(DateTime) >= '$todaydt'";
    }
    else if($entryvalue == 4){
        $a .= " ";
    }
    else {
        $datevalue = "Today";
        $a .= " and Date(DateTime) = '$todaydt'";
    }
    $out = "";
    $no = 0;
    // Set transaction isolation level and start transaction
    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try{
        //Usernameရှိမရှိစစ်
        $sql = "SELECT * FROM tblbalancein WHERE PlayerID = ? AND WinLossStatus= 'deposit' 
        ".$a." order by AID desc";        
        $stmt = $con -> prepare($sql);
        $stmt -> bind_param("i",$userid);
        $stmt -> execute();
        $res = $stmt -> get_result();
        // echo $sql;
        // $res = $con->query($sql);
        // if (!$res) {
        //     die("Query failed: " . $con->error);
        // }
        if($res -> num_rows > 0){
            $out .= '<div class="collapse-container">';
            while($data = $res -> fetch_assoc()){
                $no += 1;
                $title = "Top-up in progess, Waiting!";
                $icon = 'fa-exclamation-triangle';
                $url = roothtml."lib/images/kpay.png";
                $txt = 'style="color: rgb(234, 188, 3);"';
                $bl = 'style="border-left: 4px solid rgb(234, 188, 3);"';
                if($data["PayType"] == "WavePay"){
                    $url = roothtml."lib/images/wave.png";
                }
                if($data["PrepaidStatus"] == "success"){
                    $title = "Top-up Successful";
                    $icon = 'fa-check-circle';
                    $txt = 'style="color: rgb(10, 246, 38);"';
                    $bl = 'style="border-left: 4px solid rgb(10, 246, 38);"';
                }
                if($data["PrepaidStatus"] == "fail"){
                    $title = "Top-up Failed";
                    $icon = 'fa-times-circle';
                    $txt = 'style="color: rgb(186, 32, 5);"';
                    $bl = 'style="border-left: 4px solid rgb(186, 32, 5);"';
                }
                $out .= '
                <div class="collapse-item" '.$bl.'>
                    <div class="collapse-header" '.$txt.'>
                        <i class="fas '.$icon.'"></i>
                        <span>'.$title.'</span>
                        <i class="fas fa-caret-down toggle-icon"></i>
                    </div>
                    <div class="collapse-content">
                        <p><i class="fas fa-ellipsis-h"></i> Account No : '.$data["KpayNo"].'</p>
                        <p><i class="fas fa-ellipsis-h"></i> Account Name : '.$data["KpayName"].'</p>
                        <p><i class="fas fa-ellipsis-h"></i> TransactionNo : '.$data["TransitionCode"].'</p>
                        <p><i class="fas fa-ellipsis-h"></i> Amount : '.$data["Amount"].'</p>
                        <p><i class="fas fa-ellipsis-h"></i> DateTime : '.$data["DateTime"].'</p>
                        <p><i class="fas fa-ellipsis-h"></i> Top-up Type : '.$data["PayType"].'</p>';
                        if($data["PrepaidStatus"] == "prepaid"){
                            $out .='
                            <button class="collapse-edit-btn" id="btnedittopup" 
                                data-aid="'.$data["AID"].'" 
                                data-amt="'.$data["Amount"].'" 
                                data-code="'.$data["TransitionCode"].'" >
                                <i class="fas fa-edit"></i> Edit
                            </button>';
                        }
                    $out .='
                    </div>
                </div>
                ';  
            }
            $out .= '</div>';                 
            echo $out;
        }
        else{
            // Rollback if bet doesn't exist
            mysqli_rollback($con);
            $out .= '
                <div class="collapse-item">
                    <div class="collapse-header">
                        <i class="fa fa-bell"></i>
                        <span>Notification!</span>
                        <i class="fa fa-caret-down toggle-icon"></i>
                    </div>
                    <div class="collapse-content">
                        <p><i class="fa fa-warning"></i> There is no record for '.$datevalue.'</p>
                    </div>
                </div>
                ';  
            echo $out;
        }
        
    }
    catch(mysqli_sql_exception $e){
        mysqli_rollback($con);
        error_log("Database error in GetBalance: " . $e->getMessage());
        echo json_encode(
            array(
                "Balance"=>0,
                "ErrorCode"=>7,
                "ErrorMessage"=>"Internal Error"
            ));
    }
    catch(Exception $e){
        mysqli_rollback($con);
        error_log("System error in GetBalance: " . $e->getMessage());
        echo json_encode(
            array(
                "Balance"=>0,
                "ErrorCode"=>7,
                "ErrorMessage"=>"System Error"
            ));
    }
}

if($action == "edit_topup"){
    $aid = $_POST["aid"];
    $amount = $_POST["amt"];
    $transitioncode = $_POST["code"];

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $sql = "UPDATE tblbalancein SET Amount=?,TransitionCode=? WHERE AID = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("dsi", $amount, $transitioncode, $aid);
        if ($stmt->execute()) {
            save_log("Username ".$_SESSION['esportclient_username']." သည် Topup Amount အား ပြင်သွားသည်။");
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

//withdraw history
if($action == "show_withdraw_data"){
    $userid = $_SESSION["esportclient_userid"];
    $entryvalue = $_POST["search_withdraw"];
    $todaydt = date("Y-m-d");
    $datevalue = "";
    $a = "";
    if($entryvalue == 2){
        $datevalue = "Last 7 Day";
        $todaydt = date("Y-m-d", strtotime("-7 days"));
        $a .= " and Date(DateTime) >= '$todaydt'";
    }
    else if($entryvalue == 3){
        $datevalue = "1 Month";
        $todaydt = date("Y-m-d", strtotime("-1 month"));
        $a .= " and Date(DateTime) >= '$todaydt'";
    }
    else if($entryvalue == 4){
        $a .= " ";
    }
    else {
        $datevalue = "Today";
        $a .= " and Date(DateTime) = '$todaydt'";
    }
    $out = "";
    $no = 0;
    // Set transaction isolation level and start transaction
    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try{
        //Usernameရှိမရှိစစ်
        $sql="SELECT * FROM tblbalanceout WHERE PlayerID = ? AND WinLossStatus= 'withdraw' 
        ".$a." order by AID desc";
        
        $stmt = $con -> prepare($sql);
        $stmt -> bind_param("i",$userid);
        $stmt -> execute();
        $res = $stmt -> get_result();
        // $res = $con->query($sql);
        // if (!$res) {
        //     die("Query failed: " . $con->error);
        // }
        if($res -> num_rows > 0){
            $out .= '<div class="collapse-container">';
            while($data = $res -> fetch_assoc()){
                $no += 1;
                $title = "Withdraw in progess, Waiting!";
                $icon = 'fa-exclamation-triangle';
                $url = roothtml."lib/images/kpay.png";
                $txt = 'style="color: rgb(234, 188, 3);"';
                $bl = 'style="border-left: 4px solid rgb(234, 188, 3);"';
                if($data["PayType"] == "WavePay"){
                    $url = roothtml."lib/images/wave.png";
                }
                if($data["PrepaidStatus"] == "success"){
                    $title = "Withdraw Successful";
                    $icon = 'fa-check-square-o';
                    $txt = 'style="color: rgb(10, 246, 38);"';
                    $bl = 'style="border-left: 4px solid rgb(10, 246, 38);"';
                }
                if($data["PrepaidStatus"] == "fail"){
                    $title = "Withdraw Failed";
                    $icon = 'fa-times-circle';
                    $txt = 'style="color: rgb(186, 32, 5);"';
                    $bl = 'style="border-left: 4px solid rgb(186, 32, 5);"';
                }
                $out .= '
                <div class="collapse-item" '.$bl.'>
                    <div class="collapse-header" '.$txt.'>
                        <i class="fa '.$icon.'"></i>
                        <span>'.$title.'</span>
                        <i class="fa fa-caret-down toggle-icon"></i>
                    </div>
                    <div class="collapse-content">
                        <p><i class="fa fa-ellipsis-h"></i> Account No : '.$data["KpayNo"].'</p>
                        <p><i class="fa fa-ellipsis-h"></i> Account Name : '.$data["KpayName"].'</p>
                        <p><i class="fa fa-ellipsis-h"></i> TransactionNo : '.$data["TransitionCode"].'</p>
                        <p><i class="fa fa-ellipsis-h"></i> Amount : '.$data["Amount"].'</p>
                        <p><i class="fa fa-ellipsis-h"></i> DateTime : '.$data["DateTime"].'</p>
                        <p><i class="fa fa-ellipsis-h"></i> Receive Type : '.$data["PayType"].'</p>
                    </div>
                </div>
                ';  
            }
            $out .= '</div>';                 
            echo $out;
        }
        else{
            // Rollback if bet doesn't exist
            mysqli_rollback($con);
            $out .= '
                <div class="collapse-item">
                    <div class="collapse-header">
                        <i class="fa fa-bell"></i>
                        <span>Notification!</span>
                        <i class="fa fa-caret-down toggle-icon"></i>
                    </div>
                    <div class="collapse-content">
                        <p><i class="fa fa-warning"></i> There is no record for '.$datevalue.'</p>
                    </div>
                </div>
                ';  
            echo $out;
        }
        
    }
    catch(mysqli_sql_exception $e){
        mysqli_rollback($con);
        error_log("Database error in GetBalance: " . $e->getMessage());
        echo json_encode(
            array(
                "Balance"=>0,
                "ErrorCode"=>7,
                "ErrorMessage"=>"Internal Error"
            ));
    }
    catch(Exception $e){
        mysqli_rollback($con);
        error_log("System error in GetBalance: " . $e->getMessage());
        echo json_encode(
            array(
                "Balance"=>0,
                "ErrorCode"=>7,
                "ErrorMessage"=>"System Error"
            ));
    }
}

?>