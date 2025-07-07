<?php 

include("../config.php");
$action=$_POST["action"];

if ($action == "login") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    mysqli_query($con, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
    mysqli_begin_transaction($con);

    try {
        $sql = "SELECT * FROM tblplayer WHERE UserName=? AND Password=? FOR UPDATE";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $row = $res->fetch_assoc();
            // Save session
            $_SESSION["esportclient_userid"] = $row['AID'];
            $_SESSION["esportclient_username"] = $row['UserName'];
            $_SESSION["esportclient_userpassword"] = $row['Password'];
            mysqli_commit($con);
            echo 1;
        } 
        else {
            mysqli_rollback($con);
            echo 0;
        }
    } 
    catch (Exception $e) {
        mysqli_rollback($con);
        echo "Error: " . $e->getMessage();
    }
}

?>