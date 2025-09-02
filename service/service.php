<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <h2>SERVICE</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="gallery-container">
            <a href="viber://chat?number=959*****" class="gallery-item">
                <div class="gallery-circle">
                    <img src="<?=roothtml.'lib/img/viber.png'?>" alt="KPay">
                </div>
                <div class="gallery-caption">Viber</div>
            </a>

            <a href="https://t.me/brilliant" class="gallery-item">
                <div class="gallery-circle">
                    <img src="<?=roothtml.'lib/img/telegram.png'?>" alt="KPay">
                </div>
                <div class="gallery-caption">Telegram</div>
            </a>
        </div>
        <div class="elegant-box">
            <span class="note-icon">✨ Note ✨ </span>
            <p style="font-size:50px;">24/7</p>
            <span style="font-size:30px;">service</span>
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
            location.href = "<?= roothtml . 'wallet/topupkpay.php' ?>";
        } else {
            location.href = "<?= roothtml . 'wallet/topupwave.php' ?>";
        }
    });

});
</script>