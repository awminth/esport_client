<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<section class="bg-dark-blue">
    <div class="m-12 center-content t-box-dark-blue">
        <div class="page-header">
            <a href="<?=roothtml.'wallet/wallet.php'?>" class="back-icon">
                <i class="fa fa-mail-reply"></i>
            </a>
            <h2>TOP-UP</h2>
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
                    <p>After successful top-up, the money will be credited to your account. Please wait!</p>
                </div>
            </div>
        </div>
    </div>
</section>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {

    $(document).on("click", "#btnpayment", function(e) {
        e.preventDefault();
        var payment = $(this).data("payment");
        if (payment == "kpay") {
            location.href = "<?= roothtml . 'wallet/topupkpay.php' ?>";
        } else {
            location.href = "<?= roothtml . 'wallet/topupwave.php' ?>";
        }
    });

});
</script>