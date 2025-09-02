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
            <input type="hidden" name="action" value="register">
            <div class="form-group">
                <label for="inputField">Username
                    <span id="usernameerror" style="color: red; font-size: 13px;">(min 6,maximum 9
                        characters)</span>
                </label>
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" id="username" required>
            </div>
            <div class="form-group">
                <label for="inputField">Password
                    <span id="pwderror" style="color: red; font-size: 13px;">(min 6,maximum 15
                        characters)</span>
                </label>
                <i class="fa fa-lock"></i>
                <input type="password" name="pwd" placeholder="Password" id="pwd" required>
            </div>
            <div class="form-group">
                <label for="inputField">PhoneNo</label>
                <i class="fa fa-mobile"></i>
                <input type="text" name="phoneno" placeholder="PhoneNo" required>
            </div>
            <div class="form-group">
                <label for="inputField">Email</label>
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="inputField">NRC No</label>
                <i class="fa fa-id-card"></i>
                <input type="text" name="nrc" placeholder="Eg- 5/SAKANA(N)001425" required>
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
    var login_url = "<?php echo roothtml.'login/register_action.php'?>";

    $("#username").on("input", function() {
        var username = $(this).val();
        var regex = /^[a-zA-Z0-9_]{6,9}$/; // Letters, Numbers, and Underscore, 6 to 15 characters

        if (regex.test(username)) {
            $("#usernameerror").hide(); // Valid input
        } else {
            $("#usernameerror").show(); // Show error if invalid
        }
    });

    $("#pwd").on("input", function() {
        var password = $(this).val();
        var regex = /^[a-zA-Z0-9]{6,15}$/; // Letters, Numbers, and Underscore, 6 to 40 characters

        if (regex.test(password)) {
            $("#pwderror").hide(); // Valid input
        } else {
            $("#pwderror").show(); // Show error if invalid
        }
    });

    $("#frmregisterplayer").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var username = $("[name='username']").val();
        var regex_username = /^[a-zA-Z0-9_]{6,9}$/;
        //Check Username
        if (!regex_username.test(username)) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: '(Number, Letter and _ only.)(Username must be 6 to 9 characters)',
                duration: 1500
            });
            return false;
        }
        //Check Password
        var password = $("[name='password']").val();
        var regex_password = /^[a-zA-Z0-9]{6,15}$/;
        if (!regex_password.test(password)) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: '(Number, Letter and _ only.)(Username must be 6 to 15 characters)',
                duration: 1500
            });
            return false;
        }
        $.ajax({
            type: "post",
            url: login_url,
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Register Account is success. Running ...',
                        duration: 1500
                    });

                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'login/login.php' ?>";
                    }, 1500);
                } else if (data == 2) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Invalid username or password.',
                        duration: 1500
                    });
                } else if (data == 0) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Register data are not correct.',
                        duration: 1500
                    });
                } else {
                    // Show any other unexpected output as error
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Invalid username or password.',
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>