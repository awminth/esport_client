<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>

<div class="page-header">
    <a href="<?=roothtml.'login/login.php'?>" class="back-icon">
        <i class="fas fa-mail-reply"></i>
    </a>
    <h2>REGISTER</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="logo-container">
            <div class="profile-circle">
                <img src="<?=roothtml.'lib/img/loginlogo.png'?>" alt="Login Logo">
            </div>
        </div>
        <form id="frmregisterplayer" method="POST">
            <div class="form-group">
                <label for="inputField">Username</label>
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="inputField">Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="pwd" placeholder="Password" required>
            </div>
            <div class="modern-form-group">
                <label for="bank-account">Agent</label>
                <select id="search_topup" required name="agentid">
                    <option selected disabled value="">Choose Agent</option>
                    <?=load_agent()?>
                </select>
            </div>
            <div class="form-group">
                <label for="inputField">Display Name</label>
                <i class="fa fa-tags"></i>
                <input type="text" name="displayname" placeholder="Display name" required>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn-liquid">REGISTER</button>
            </div>
            <br>
        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    var login_url = "<?php echo roothtml.'login/login_action.php'?>";

    $("#frmregisterplayer").on("submit", function(e) {
        e.preventDefault();
        // var formData = new FormData(this);
        // $.ajax({
        //     type: "post",
        //     url: login_url,
        //     data: formData,
        //     contentType: false,
        //     processData: false,
        //     success: function(data) {
        //         if (data == 1) {
        //             swal({
        //                 title: "Success",
        //                 text: "Registered successful! ",
        //                 icon: "success",
        //                 buttons: false,
        //             });
        //             location.href = "<?=roothtml.'login/login.php'?>"
        //         } else if (data == 2) {
        //             swal("Error", "Invalid Username or Password", "error");
        //         } else if (data == 0) {
        //             swal("Warning!", "Please retype your password.", "warning");
        //         } else {
        //             // Show any other unexpected output as error
        //             swal("Error", "Change Pwd failed: " + data, "error");
        //         }
        //     }
        // });
        alert("Click Register Save");
    });

});
</script>