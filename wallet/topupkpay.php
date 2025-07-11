<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <a href="<?=roothtml.'wallet/topup.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>TOP-UP</h2>
</div>
<div class="login-container">
    <div class="pay-container">
        <div class="pay-item">
            <div class="pay-circle">
                <img src="<?=roothtml.'lib/img/kpay.png'?>" alt="KPay">
            </div>
        </div>
        <div class="receive-box">
            <span>Transfer Account</span>
            <p>Kpay Account Name : Test</p>
            <p>Kpay No : <strong id="kpay-number">09123456789</strong>
                <span class="copy-container">
                    <i class="fa fa-copy copy-icon" onclick="copyKpay()"></i>
                    <span id="copy-tooltip" class="copy-tooltip">Copied!</span>
                </span>
            </p>
        </div>
        <form id="frmtopupkpay" method="POST">
            <input type="hidden" name="action" value="topupkpay" />
            <div class="form-group">
                <label for="inputField">Kpay Name</label>
                <i class="fas fa-user"></i>
                <input type="text" name="kpayname" placeholder="Your Kpay Name" required>
            </div>
            <div class="form-group">
                <label for="inputField">Kpay Number</label>
                <i class="fas fa-phone"></i>
                <input type="number" name="kpayno" placeholder="09XXXXXXXX" required>
            </div>
            <div class="form-group">
                <label for="inputField">Amount</label>
                <i class="fas fa-funnel-dollar"></i>
                <input type="number" name="amount" id="amountInput" placeholder="Amount" required>
            </div>
            <div class="form-group">
                <label for="inputField">Transaction Number</label>
                <i class="fas fa-clipboard-list"></i>
                <input type="text" name="transactionno" placeholder="Transaction Number" required>
            </div>
            <div class="form-group note-group">
                <label class="note-label">
                    <span class="note-icon" style="color:red;">✨ Note ✨ </span>
                    <span class="note-text" style="color:white;">TransactionNo stands for your last 6 digit numbers of
                        KBZ
                        Pay.</span>
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
function copyKpay() {
    const kpayNumber = document.getElementById("kpay-number").innerText;
    // Fallback for older browsers
    if (!navigator.clipboard) {
        return fallbackCopy(kpayNumber);
    }
    navigator.clipboard.writeText(kpayNumber).then(function() {
        showTooltip();
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
        fallbackCopy(kpayNumber);
    });
}

function showTooltip() {
    const tooltip = document.getElementById("copy-tooltip");
    tooltip.style.opacity = "1";

    setTimeout(function() {
        tooltip.style.opacity = "0";
    }, 1500);
}

function fallbackCopy(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    document.body.appendChild(textarea);
    textarea.select();
    try {
        document.execCommand('copy');
        showTooltip();
    } catch (err) {
        console.error('Fallback copy failed: ', err);
        alert('Copy failed. Please manually select and copy the number.');
    }
    document.body.removeChild(textarea);
}

$(document).ready(function() {
    $('.amount-btn').click(function() {
        var value = $(this).text();
        var cleanAmount = Number(value.replace(/,/g, ''));
        $('#amountInput').val(cleanAmount);
    });

    $("#frmtopupkpay").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var amt = $("[name='amount']").val();
        if (Number(amt) <= 0) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please fill amount.',
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
                        message: 'Topup successful! Redirecting....',
                        duration: 1500
                    });
                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'wallet/wallet.php' ?>";
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'info',
                        title: 'Information!',
                        message: 'Invalid kpayname or kpayno.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Topup failed : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>