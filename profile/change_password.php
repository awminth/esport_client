<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <h2>CHANGE PASSWORD</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="logo-container">
            <div class="profile-circle">
                <img src="<?=roothtml.'lib/img/loginlogo.png'?>" alt="Login Logo">
            </div>
        </div>
        <form id="frmchangepwd" method="POST">
            <input type="hidden" name="action" value="change_pwd" />
            <div class="form-group">
                <label for="inputField">Current Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="currentpwd" placeholder="Current Password" required>
            </div>
            <div class="form-group">
                <label for="inputField">New Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="newpwd" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <label for="inputField">Retype Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="retypenewpwd" placeholder="Retype Password" required>
            </div>
            <div class="elegant-box">
                <span>✨ Note! ✨</span>
                <p>To protect against fraud, never share your PIN with anyone. Even service staff are
                    not authorized to ask for your PIN. If someone does, it is a scam.</p>
            </div>
            <button type="submit" class="btn-liquid"><i class="fas fa-sign-in"></i>SAVE CHANGE</button>

        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    var profile_url = "<?php echo roothtml.'profile/mainprofile_action.php'?>";

    $("#frmchangepwd").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "post",
            url: profile_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Change password is successful.',
                        duration: 1500
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'warning',
                        title: 'Warning!',
                        message: 'New Pwd and Retype Pwd not match.',
                        duration: 1500
                    });
                }else if (data == 2) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Invalid Password.',
                        duration: 1500
                    });
                } else if (data == 3) {
                    showToast({
                        type: 'info',
                        title: 'Information!',
                        message: 'Current Password is wrong.',
                        duration: 1500
                    });
                }  else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Change Pwd fail : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>