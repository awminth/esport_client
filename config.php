<?php 
session_start();

date_default_timezone_set("Asia/Rangoon");

define('server_name',$_SERVER['HTTP_HOST']);

if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
    $chk_link = "https";
}else{
    $chk_link = "http";
}

define('root',__DIR__.'/');

//Local
define('roothtml',$chk_link."://".server_name."/esport_client/");
$con = new mysqli("localhost","root","root","esport");
// for admin 
define('roothtml_admin',$chk_link."://".server_name."/esport_admin/");

define('curlink',basename($_SERVER['SCRIPT_NAME']));

//Online
// define('roothtml',$chk_link."://".server_name."/");
// $con = new mysqli("65.60.39.46","hitupkur_admin","kyoungunity*007*","hitupkur_esport");

mysqli_set_charset($con,"utf8");

$color="secondary";
$share = array("Editor","Viewer");
$usertype=array('Admin','User');
$companykey = "E258AF866BB444E6A116C52B24DAB7C5";
// $secretID = "833633";
// ======= start for ibet 789 process ==========
// sign secret and agent
$secretID = "833633";  
$agent  = "ismmc1";
// exchange point amount
$exchange_amt = 100; 

// Generic API Call Function
function callIbetAPI($url, $data) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $res = curl_exec($ch);
    curl_close($ch);
    return json_decode($res, true);
}

// error code list
$ibet_errorlist = [
    "5200402" => "Invalid secret key",
    "5200403" => "Cannot create account",
    "5200404" => "Invalid parameters",
    "5200405" => "Calling failed",
    "5200406" => "Some settings are exceed limit ",
    "5200407" => "Client trans Id exists",
    "5200408" => "Invalid role, agent name input is wrong",
    "5200409" => "Invalid username",
    "5200410" => "Invalid agent",
    "5200411" => "Invalid username, username not available or not belong to agent",
    "5200412" => "Some parameters wrong",
    "5200413" => "User already exist",
    "5200414" => "No result",
];
// ======= end ibet 789 process ==========

function load_username(){
    global $con;
    $sql="select * from tbluser order by AID desc";
    $result=mysqli_query($con,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<i class='bi-person-circle'></i>
            <option value='{$row["UserName"]}'>{$row["UserName"]}</option>";
    }
    return $out;
}

function enDate1($date){
    if($date!=NULL && $date!=''){
        $date = date_create($date);
        $date = date_format($date,"j F Y");
        return $date;
    }else{
        return "";
    }   
}

function enDate2($date){
    if($date!=NULL && $date!=''){
        $date = date_create($date);
        $date = date_format($date,"F Y");
        return $date;
    }else{
        return "";
    }   
}

function enDate3($date){
    if($date!=NULL && $date!=''){
        $date = date_create($date);
        $date = date_format($date,"M - Y");
        return $date;
    }else{
        return "";
    }   
}

function enTime($date){
    if($date!=NULL && $date!=''){
        $date = date_create($date);
        $date = date_format($date,"H:i A");
        return $date;
    }else{
        return "";
    }   
}

function load_agent(){
    global $con;
    $sql="SELECT a.*, SUM(r.TotalRate) AS total_rating
    FROM tblagent a 
    LEFT JOIN tblagentrating r ON a.AID = r.AgentID 
    WHERE a.Status = 'Active' 
    GROUP BY a.AID ORDER BY total_rating DESC";
    $result=mysqli_query($con,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["UserName"]}</option>";
    }
    return $out;
}

function GetString($sql, $params = []) {
    global $con;
    $str = "";

    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    if (!empty($params)) {
        // Generate bind types automatically
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $stmt->bind_result($str);
    $stmt->fetch();
    $stmt->close();

    return $str;
}

function GetInt($sql, $params = []) {
    global $con;
    $value = 0;

    $stmt = $con->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $con->error);
    }

    if (!empty($params)) {
        // Auto-generate parameter types
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }

        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $stmt->bind_result($value);
    $stmt->fetch();
    $stmt->close();

    return $value;
}

function GetBool($sql){
    global $con;
    $str = false;   
    $result=mysqli_query($con,$sql) or die("Query Fail");
    if(mysqli_num_rows($result)>0){
        $str = true;
    }
    return $str;
}

function enDate($date){
    if($date!=NULL && $date!=''){
        $date = date_create($date);
        $date = date_format($date,"d-m-Y");
        return $date;
    }else{
        return "";
    }
   
}

function load_user(){
    global $con;
    $loginid= $_SESSION["userid"];
    $sql="select * from tbluser ";
    $result=mysqli_query($con,$sql) or die("Query fail.");
    $out="";
    while($row = mysqli_fetch_array($result)){
        $out.="<option value='{$row["AID"]}'>{$row["UserName"]}</option>";
    }
    return $out;
}

function save_log($des){
    global $con;
    $dt=date("Y-m-d H:i:s");
    $userid=$_SESSION['esportclient_userid'];
    $sql="insert into tbllog (Description,UserID,DateTime) values ('{$des}'
    ,$userid,'{$dt}')";
    mysqli_query($con,$sql);   
}

function NumtoText($number){
    $array = [
        '1' => 'First',
        '2' => 'Second',
        '3' => 'Third',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        '10' => 'Ten',
    ];
    return strtr($number, $array);
}

?>