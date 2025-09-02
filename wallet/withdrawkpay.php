<?php 
    include("../config.php"); 
    include(root.'master/header.php');

    $current_amt = GetInt("SELECT Balance FROM tblplayer WHERE AID = ?", [$_SESSION["esportclient_userid"]]);
?>


<div class="page-header">
    <a href="<?=roothtml.'wallet/withdraw.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>WITHDRAW</h2>
</div>
<div class="login-container">
    <div class="pay-container">
        <div class="pay-item">
            <div class="pay-circle">
                <img src="<?=roothtml.'lib/img/kpay.png'?>" alt="KPay">
            </div>
        </div>
        <form id="frmwithdrawkpay" method="POST">
            <input type="hidden" name="action" value="withdrawkpay" />
            <input type="hidden" name="current_amt" value="<?=$current_amt?>" />
            <div class="form-group">
                <label for="inputField">Receive Kpay Name</label>
                <i class="fas fa-user"></i>
                <input type="text" name="kpayname" placeholder="Your Kpay Name" required>
            </div>
            <div class="form-group">
                <label for="inputField">Receive Kpay No</label>
                <i class="fas fa-phone-alt"></i>
                <input type="number" name="kpayno" placeholder="Your Kpay No" required>
            </div>
            <div class="form-group">
                <label for="inputField">Amount</label>
                <i class="fas fa-funnel-dollar"></i>
                <input type="number" name="amount" placeholder="Amount" required>
            </div>
            <div class="form-group note-group">
                <label class="note-label">
                    <span class="note-icon" style="color:red;">✨ Note ✨ </span>
                    <span class="note-text" style="color:white;">The money will arrive in your account
                        within 30 minutes of a successful withdrawal.</span>
                </label>
            </div>
            <div class="amount-container">
                <div class="amount-grid">
                    <button type="button" class="amount-btn">
                        <span class="amount">5,000</span>
                    </button>
                    <button type="button" class="amount-btn">
                        <span class="amount">10,000</span>
                    </button>
                    <button type="button" class="amount-btn">
                        <span class="amount">50,000</span>
                    </button>
                    <button type="button" class="amount-btn">
                        <span class="amount">100,000</span>
                    </button>
                    <button type="button" class="amount-btn">
                        <span class="amount">300,000</span>
                    </button>
                    <button type="button" class="amount-btn">
                        <span class="amount">500,000</span>
                    </button>
                </div>
            </div>
            <button type="submit" class="btn-liquid">
                <i class="fas fa-check-circle"></i>
                Confirm
            </button>
        </form>
    </div>
</div>



<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    $('.amount-btn').click(function() {
        var value = $(this).text();
        var cleanAmount = Number(value.replace(/,/g, ''));
        $("[name='amount']").val(cleanAmount);
    });

    $("#frmwithdrawkpay").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var amt = $("[name='amount']").val();
        var current_amt = $("[name='current_amt']").val();
        if (Number(amt) <= 0) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please fill amount.',
                duration: 1500
            });
            return false;
        }
        if (Number(amt) > Number(current_amt)) {
            showToast({
                type: 'info',
                title: 'Information!',
                message: 'Your Balance is not enough for withdraw.',
                duration: 1500
            });
            return false;
        }
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'wallet/wallet_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Withdraw successful! Redirecting...',
                        duration: 1500
                    });

                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'wallet/wallet.php' ?>";
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Invalid kpayname or kpayno.',
                        duration: 1500
                    });
                } else if (data == 2) {
                    showToast({
                        type: 'info',
                        title: 'Information!',
                        message: 'Your Balance is not enough for withdraw.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Withdraw fail : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>