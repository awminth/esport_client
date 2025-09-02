<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <a href="<?=roothtml.'wallet/wallet.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>WITHDRAW</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="gallery-container">
            <div class="gallery-item" id="btnpayment" data-payment="kpay">
                <div class="gallery-circle">
                    <img src="<?=roothtml.'lib/img/kpay.png'?>" alt="KPay">
                </div>
                <div class="gallery-caption">KPay</div>
            </div>

            <div class="gallery-item" id="btnpayment" data-payment="wave">
                <div class="gallery-circle">
                    <img src="<?=roothtml.'lib/img/wave.png'?>" alt="KPay">
                </div>
                <div class="gallery-caption">WavePay</div>
            </div>
        </div>
        <div class="elegant-box">
            <span>✨ Note! ✨</span>
            <p>The money will arrive in your account within 30 minutes of a successful withdrawal.</p>
        </div>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {

    $(document).on("click", "#btnpayment", function(e) {
        e.preventDefault();
        var payment = $(this).data("payment");
        if (payment == "kpay") {
            location.href = "<?= roothtml . 'wallet/withdrawkpay.php' ?>";
        } else {
            location.href = "<?= roothtml . 'wallet/withdrawwave.php' ?>";
        }
    });

});
</script>