<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>
<style>
.custom-checkbox {
    transform: scale(1.2);
    margin-right: 8px;
}

.checkbox-label {
    color: red;
    font-size: 16px;
}
</style>

<div class="page-header">
    <h2>LOGIN</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="logo-container">
            <div class="profile-circle">
                <img src="<?=roothtml.'lib/img/loginlogo.png'?>" alt="Login Logo">
            </div>
        </div>
        <form id="frmlogin" method="POST">            
            <div class="form-group">
                <label for="inputField">Username</label>
                <i class="fa fa-user"></i>
                <input type="text" name="username1" placeholder="Username" required>
            </div>
            <div class="form-group">
                <label for="inputField">Password</label>
                <i class="fa fa-lock"></i>
                <input type="password" name="password1" placeholder="Password" required>
            </div>
            <button type="submit" class="btn-liquid"><i class="fas fa-sign-in"></i>LOGIN</button>
            <div class="login-footer">
                don't have an account yet?
                <strong class="register">
                    <a href="<?=roothtml.'login/register.php'?>">&nbsp;&nbsp;Sign up now</a>
                </strong>
            </div>
            <br>
        </form>
    </div>
</div>

<!-- The Modal -->
<div id="policyModal" class="custom-modal">
    <div class="modal-content modal-normal">
        <div class="modal-header bg-color-blue">
            <h3>Our Policy</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="frmloginsave" method="POST">
            <input type="hidden" name="action" value="login" />
            <input type="hidden" name="username" />
            <input type="hidden" name="password" />
            <div class="modal-body bg-color-blue">
                <p class="my-p">
                    Myanmar (formerly Burma) is a Southeast Asian nation
                    of more than 100 ethnic groups, bordering India, Bangladesh,
                    China, Laos and Thailand. Yangon (formerly Rangoon), the country's
                    largest city, is home to bustling markets, numerous parks and lakes,
                    and the towering,
                    gilded Shwedagon Pagoda, which contains Buddhist
                    relics and dates to the 6th century.
                    Myanmar (formerly Burma) is a Southeast Asian nation
                    of more than 100 ethnic groups, bordering India, Bangladesh,
                    China, Laos and Thailand. Yangon (formerly Rangoon), the country's
                    largest city, is home to bustling markets, numerous parks and lakes,
                    and the towering,
                    gilded Shwedagon Pagoda, which contains Buddhist
                    relics and dates to the 6th century.
                </p>
                <input type="checkbox" id="agree" class="custom-checkbox">
                <label for="agree" class="checkbox-label">I agree this policy.</label>
            </div>
            <div class="modal-footer bg-color-white">
                <button class="modal-btn cancel-btn">Cancel</button>
                <button type="submit" class="modal-btn confirm-btn">Confirm</button>
            </div>
        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    var login_url = "<?php echo roothtml.'login/login_action.php'?>";

    $("#frmlogin").on("submit", function(e) {
        e.preventDefault();
        var username = $("[name='username1']").val();
        var password = $("[name='password1']").val();
        $("[name='username']").val(username);
        $("[name='password']").val(password);
        $("#policyModal").fadeIn(300);
    });

    $(document).on("click", ".cancel-btn, .close-modal", function(e) {
        e.preventDefault();
        $("#policyModal").fadeOut(300);
    });

    $("#frmloginsave").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        if (!$("#agree").is(":checked")) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please confirm that you agree to our policy.',
                duration: 2000
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
                        message: 'Login is success. Running ...',
                        duration: 1500
                    });

                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'index.php' ?>";
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Invalid Account Detail.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Login fail : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>