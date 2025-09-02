<?php 

include("../config.php");
$action=$_POST["action"];

if($action == "change_pwd"){
    $userid = $_SESSION["esportclient_userid"];
    $userpwd = $_SESSION["esportclient_userpassword"];
    $currentpwd = $_POST["currentpwd"];
    $newpwd = $_POST["newpwd"];
    $retypepwd = $_POST["retypenewpwd"];

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        if($userpwd == $currentpwd){
            if($newpwd == $retypepwd){
                $sql = "UPDATE tblplayer SET Password=? WHERE AID = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("si", $retypepwd, $userid);
        
                if ($stmt->execute()) {
                    $_SESSION["esportclient_userpassword"] = $newpwd;
                    save_log("Username ".$_SESSION['esportclient_username']." သည်Account Passwordအား ".$retypepwd." သို့ပြောင်းသွားသည်။");
                    mysqli_commit($con);
                    echo 1;
                }
                else {
                    mysqli_rollback($con);
                    echo 2;
                }
            }
            else{
                mysqli_rollback($con);
                echo 0;
            }  
        }else{
            echo 3;
        }        
    } 
    catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

if($action == "quiz_assign"){
    // first check today quiz is or not
    $lastdt = date("Y-m-d");
    $today = date('l'); // "Monday","Friday"
    $chk_assign = GetInt("SELECT AID FROM tblquestion_assign WHERE LastDate = ?", [$lastdt]);
    if($chk_assign == 0 && $today == "Friday"){
        $last_questionID = GetInt("SELECT QuestionID FROM tblquestion_assign ORDER BY AID DESC LIMIT 1");
        
        // not record
        $sql = "select * from tblquestion where AID>{$last_questionID} limit 5";
        $res = mysqli_query($con,$sql);
        if(mysqli_num_rows($res) > 0){
            while($row = mysqli_fetch_array($res)){
                $sql_in = "INSERT INTO tblquestion_assign (QuestionID,LastDate)  
                VALUES (?, ?)";
                $stmt_detail = $con -> prepare($sql_in);
                $stmt_detail -> bind_param("is", $row["AID"], $lastdt);
                $stmt_detail->execute();
            }
        }  
    }
}

if($action == "show_quiz"){
    $out = '';
    $playerid = $_SESSION["esportclient_userid"];    
    // Check if today is Friday
    $today = date('l'); // "Monday","Friday"
    if ($today !== "Friday") {
        echo "<p style='color:#ffe10a;padding:50px;' align='center'>
                <i class='fas fa-award' style='font-size:25px;color:#ffe10a;padding-right:5px;'></i>
                 Quizes can only be taken every Friday.</p>";
        exit;
    }else{
        // check already answer or not
        $chk_today = date("Y-m-d");
        $point_dt = GetString("SELECT DATE(ChkDate) FROM tblpoints WHERE PlayerID = ?", [$playerid]);
        if($chk_today !== $point_dt){
            $sql = "SELECT * FROM tblquestion 
            WHERE AID IN (SELECT QuestionID FROM tblquestion_assign WHERE LastDate='{$chk_today}') 
            ORDER BY AID";
            $stmt = $con -> prepare($sql);
            $stmt -> execute();
            $res = $stmt -> get_result();
            if($res -> num_rows > 0){
                $no = 0;
                $out .= '<input type="hidden" name="action" value="save_quiz" />';
                while($data = $res -> fetch_assoc()){
                    $no = $no + 1;
                    $out .= '
                    <div class="question-block">
                        <input type="hidden" name="question'.$no.'" value="'.$data["AID"].'" />
                        <input type="hidden" name="mark'.$no.'" value="'.$data["Mark"].'" />
                        <div class="question">
                            '.$no.'. '.$data["Question"].' ( <span>'.$data["Mark"].' Point</span> )
                        </div>
                        <div class="options">
                            <div class="option">
                                <label><input type="radio" name="choice_ans'.$no.'" value="A"> A. '.$data["ChoiceA"].'</label>
                            </div>
                            <div class="option">
                                <label><input type="radio" name="choice_ans'.$no.'" value="B"> B. '.$data["ChoiceB"].'</label>
                            </div>
                            <div class="option">
                                <label><input type="radio" name="choice_ans'.$no.'" value="C"> C. '.$data["ChoiceC"].'</label>
                            </div>
                            <div class="option">
                                <label><input type="radio" name="choice_ans'.$no.'" value="D"> D. '.$data["ChoiceD"].'</label>
                            </div>
                        </div>
                    </div>
                    ';
                }
                $out .= '<button type="submit" class="btn-liquid">Submit</button>';
            }else{
                $out.= "<p style='color:#ffe10a;padding:50px;' align='center'>
                    <i class='fas fa-bell' style='font-size:25px;color:#ffe10a;padding-right:5px;'></i>
                    There are no more questions left to answer. Please wait! The provider team will notification you.
                </p>";
            }   
            echo $out; 
        }else{
            echo "<p style='color:red;padding:50px;' align='center'>
                <i class='fas fa-hourglass-half' style='font-size:30px;color:white;padding-right:10px;'></i> The questions for this week 
                have already been answered. Please wait for the next time.</p>";
        }  
    } 
}

if($action == "save_quiz"){
    $out = "";
    $playerid = $_SESSION["esportclient_userid"];
    $playername = $_SESSION["esportclient_username"];
    $correct = [];
    $choice = [];
    $mark = [];
    $vno = date("Ymd-His");
    $dt = date("Y-m-d H:i:s");

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);
    try{
        $totalpoint = 0;
        for ($i = 1; $i <= 5; $i++) {
            $question[$i] = isset($_POST["question$i"]) ? $_POST["question$i"] : 0;
            $choice_ans[$i] = isset($_POST["choice_ans$i"]) ? $_POST["choice_ans$i"] : "";
            $mark[$i] = isset($_POST["mark$i"]) ? $_POST["mark$i"] : 0;

            $correct_ans = GetString("SELECT CorrectAnswer FROM tblquestion WHERE AID = ?", [$question[$i]]);
            if($correct_ans == $choice_ans[$i]){
                $totalpoint = $totalpoint + $mark[$i];
            }

            $sql_detail = "INSERT INTO tblanswerdetail (QuestionID,ChooseAnswer,VNO)  
            VALUES (?, ?, ?)";
            $stmt_detail = $con -> prepare($sql_detail);
            $stmt_detail -> bind_param("iss", $question[$i], $choice_ans[$i], $vno);
            $stmt_detail->execute();
        }
        $sql_ans = "INSERT INTO tblanswer (PlayerID,VNO,TotalPoint,DT) 
        VALUES (?, ?, ?, ?)";
        $stmt_ans = $con -> prepare($sql_ans);
        $stmt_ans -> bind_param("isds", $playerid, $vno, $totalpoint, $dt);
        if($stmt_ans->execute()){
            $chk = GetInt("SELECT AID FROM tblpoints WHERE PlayerID = ?", [$playerid]);
            if($chk > 0){
                $current_point = GetInt("SELECT Points FROM tblpoints WHERE PlayerID = ?", [$playerid]);
                $temp_point = $current_point + $totalpoint;
                $sql_upd = "UPDATE tblpoints set Points = ?, ChkDate = ? WHERE PlayerID = ?";
                $stmt_upd = $con -> prepare($sql_upd);
                $stmt_upd -> bind_param("dsi", $temp_point, $dt, $playerid);
                if($stmt_upd -> execute()){
                    save_log("Username : ".$playername." သည် Quiz ဖြေသွားသည်။");
                    mysqli_commit($con);
                    echo 1;
                }else{
                    error_log("Save Point update in tblpoints ".$stmt_upd->error."\n", 3, root."profile/my_log_file.log");
                    mysqli_rollback($con);
                    echo 0;
                }
            }else{
                $sql_in = "INSERT INTO tblpoints (PlayerID,PlayerName,Points,ChkDate)  
                VALUES (?, ?, ?, ?)";
                $stmt_in = $con -> prepare($sql_in);
                $stmt_in -> bind_param("isds", $playerid, $playername, $totalpoint, $dt);
                if($stmt_in -> execute()){
                    save_log("Username : ".$playername." သည် Quiz ဖြေသွားသည်။");
                    mysqli_commit($con);
                    echo 1;
                }else{
                    error_log("Save Point insert in tblpoints ".$stmt_in->error."\n", 3, root."profile/my_log_file.log");
                    mysqli_rollback($con);
                    echo 0;
                }
            }
        }else{
            error_log("Save Point in tblanswer ".$stmt_ans->error."\n", 3, root."profile/my_log_file.log");
            mysqli_rollback($con);
            echo 0;
        }
    }catch (mysqli_sql_exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

if($action == "go_quiz_detail"){
    unset($_SESSION["go_quiz_detail_vno"]);
    $out = "";
    $playerid = $_SESSION["esportclient_userid"];
    $sql = "SELECT * FROM tblanswer WHERE PlayerID = ? 
    ORDER BY AID DESC";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("i", $playerid);
    $stmt -> execute();
    $res = $stmt -> get_result();
    if($res -> num_rows > 0){
        while($row = $res -> fetch_assoc()){
            $out .= '
            <a href="#" class="point-detail" 
                id="btn_godetail" 
                data-vno="'.$row["VNO"].'" >
                <span>'.$row["VNO"].'</span>
                <span>'.$row["TotalPoint"].' 
                    <i class="fas fa-award" style="color:#ffe10a;"></i></span>
            </a>
            ';
        }
    }else{
        $out .= '
        <a href="#" class="point-detail"  >
            <span>There is no quiz record.</span>
        </a>
        ';
    }
    echo $out;
}

if($action == "go_detail"){
    $vno = $_POST["vno"];
    $_SESSION["go_quiz_detail_vno"] = $vno;
    echo 1;
}

if($action == "show_quiz_detail"){
    $out = '';
    $vno = $_SESSION["go_quiz_detail_vno"];
    $sql = "SELECT d.ChooseAnswer,q.* FROM tblanswerdetail d,tblquestion q 
    WHERE d.QuestionID=q.AID AND d.VNO = ? ";
    $stmt = $con -> prepare($sql);
    $stmt -> bind_param("s", $vno);
    $stmt -> execute();
    $res = $stmt -> get_result();
    if($res -> num_rows > 0){
        $no = 0;
        while($data = $res -> fetch_assoc()){
            $no = $no + 1;
            $a = "disabled";
            $b = "disabled";
            $c = "disabled";
            $d = "disabled";
            if($data["CorrectAnswer"] == "A"){
                $a = "checked";
            }
            if($data["CorrectAnswer"] == "B"){
                $b = "checked";
            }
            if($data["CorrectAnswer"] == "C"){
                $c = "checked";
            }
            if($data["CorrectAnswer"] == "D"){
                $d = "checked";
            }
            $out .= '
            <div class="question-block">
                <div class="question">
                    '.$no.'. '.$data["Question"].' ( <span>'.$data["Mark"].' Point</span> )
                </div>
                <div class="options">
                    <div class="option">
                        <label><input type="radio" name="choice_ans'.$no.'" '.$a.'> A. '.$data["ChoiceA"].'</label>
                    </div>
                    <div class="option">
                        <label><input type="radio" name="choice_ans'.$no.'" '.$b.'> B. '.$data["ChoiceB"].'</label>
                    </div>
                    <div class="option">
                        <label><input type="radio" name="choice_ans'.$no.'" '.$c.'> C. '.$data["ChoiceC"].'</label>
                    </div>
                    <div class="option">
                        <label><input type="radio" name="choice_ans'.$no.'" '.$d.'> D. '.$data["ChoiceD"].'</label>
                    </div>
                    <p>
                    <p>Your Choose : <span style="color:#fea035;padding-left:10px;font-size:20px;">'.$data["ChooseAnswer"].'</span></p>
                </div>
            </div>
            ';
        }
    }
    echo $out;
}

if($action == "exchange_point"){
    $pts = $_POST["pts"];
    $current_pts = $_POST["hid_pts"];
    $playerid = $_SESSION["esportclient_userid"] ?? 0;
    $playername = $_SESSION["esportclient_username"] ?? "";
    $fialpoint = $current_pts - $pts;
    $receive_amt = $pts * $exchange_amt;
    $dt = date("Y-m-d");
    $rating_one = $_POST["rating_one"] ?? 0; 
    $rating_two = $_POST["rating_two"] ?? 0; 
    $rating_three = $_POST["rating_three"] ?? 0; 
    $totalrate = $rating_one + $rating_two + $rating_three;

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try{
        $sql = "UPDATE tblpoints SET Points = ? WHERE PlayerID = ? ";
        $stmt = $con -> prepare($sql);
        $stmt -> bind_param("di", $fialpoint, $playerid);
        if($stmt -> execute()){
            // get player balance
            $player_balance = GetInt("SELECT Balance FROM tblplayer WHERE AID = ?", [$playerid]);
            $final_balance = $player_balance + $receive_amt;
            // update player balance
            $sql_upd = "UPDATE tblplayer SET Balance = ? WHERE AID = ?";
            $stmt_upd = $con -> prepare($sql_upd);
            $stmt_upd -> bind_param("di", $final_balance, $playerid);
            $stmt_upd -> execute();

            // insert player exchange table
            $sql_in = "INSERT INTO tblexchangepoint (PlayerID,PlayerName,Point,Amount,Date) 
            VALUES (?, ?, ?, ?, ?)";
            $stmt_in = $con -> prepare($sql_in);
            $stmt_in -> bind_param("isdds", $playerid, $playername, $pts, $receive_amt, $dt);
            $stmt_in -> execute();

            //insert points to tblagentrating
            $agentid = GetInt("SELECT AgentID FROM tblplayer WHERE AID = ?", [$playerid]);
            $agentname = GetString("SELECT AgentName FROM tblplayer WHERE AID = ?", [$playerid]);
            $chk = 0;
            $chk = GetInt("SELECT AID FROM tblagentrating WHERE PlayerID = ?", [$playerid]);
            if($chk > 0){
                $sql_ratein = "UPDATE tblagentrating SET Desc1 = ?,Desc2 = ?, Desc3 = ?,
                TotalRate = ?, Date = ? WHERE PlayerID = ?";
                $stmt_ratein = $con -> prepare($sql_ratein);
                $stmt_ratein -> bind_param("ddddsi", $rating_one, $rating_two, 
                $rating_three, $totalrate, $dt, $playerid);
                $stmt_ratein -> execute();
            }
            else{
                $sql_ratein = "INSERT INTO tblagentrating (AgentID,AgentName,Desc1,Desc2,Desc3,TotalRate,
                PlayerID,Date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt_ratein = $con -> prepare($sql_ratein);
                $stmt_ratein -> bind_param("isddddis", $agentid, $agentname, $rating_one, $rating_two, 
                $rating_three, $totalrate, $playerid, $dt);
                $stmt_ratein -> execute();
            }

            save_log("Username ".$_SESSION['esportclient_username']." သည် Point: ".$pts." အား exchange လုပ်သွားသည်။");
            mysqli_commit($con);
            echo 1;
        }else{
            mysqli_rollback($con);
            error_log("Error in point update : ".$stmt->error."\n", 3, root."profile/my_log_file.log");
            echo 0;
        }
    }catch(mysqli_sql_exception $e){
        mysqli_rollback($con);
        error_log("Database error in GetBalance: " . $e->getMessage());
        echo $e->getMessage();
    }    
}

if($action == "show_notification_data"){
    $out = "";
    $sql = "SELECT * FROM tblnotification WHERE Status = 0 ORDER BY AID DESC";
    $stmt = $con -> prepare($sql);
    $stmt -> execute();
    $res = $stmt -> get_result();
    if($res -> num_rows > 0){
        while($row = $res -> fetch_assoc()){
            $out .= '
            <div class="notification-item">
                <div class="notification-title">📅 &nbsp;&nbsp;'.$row["Title"].'</div>
                <div class="notification-description">
                    <p>'.$row["Description"].'</p>
                    <span>
                        <i class="fas fa-clock" style="padding-right:10px;"></i>
                        '.enDate1($row["DT"]).'
                    </span>
                </div>
            </div>
            ';
        }
    }else{
        $out .= '
        <p style="color:#ffe10a;padding:50px;" align="center">
            Notification is not found.</p>
        ';
    }    
    echo $out;
}



?>