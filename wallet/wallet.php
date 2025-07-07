<?php 
    include("../config.php"); 
    include(root.'master/header.php');

    $getAmount = GetInt("SELECT Balance FROM tblplayer WHERE UserName = ?", [$_SESSION["esportclient_username"]]);
?>


<div class="page-header">
    <h2>Wallet</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="balance-card">
            <div class="balance-label">BALANCE <span id="toggleBalance"><i class="fa fa-eye-slash"
                        id="eyeIcon"></i></span></div>
            <div class="balance-amount" id="balanceText">...... Ks</div>
        </div>

        <div class="action-buttons">
            <button class="action-btn" id="btnmainwallet" data-name="topup">
                <i class="fa fa-shopping-bag"></i>
                <span>TOPUP </span>
            </button>
            <button class="action-btn" id="btnmainwallet" data-name="withdraw">
                <i class="fas fa-money-check-alt"></i>
                <span>WITHDRAW</span>
            </button>
            <button class="action-btn" id="btnmainwallet" data-name="history">
                <i class="fas fa-history"></i>
                <span>HISTORY</span>
            </button>
        </div>

        <div class="guide-section">
            <h3>Guides</h3>
            <div class="guide-links">
                <a href="#" class="guide-link">
                    <span>Top Up Guide</span>
                </a>
                <a href="#" class="guide-link">
                    <span>Withdraw Guide</span>
                </a>
            </div>
        </div>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    let isVisible = true;

    document.getElementById("toggleBalance").addEventListener("click", function() {
        const icon = document.getElementById("eyeIcon");
        const balance = document.getElementById("balanceText");

        if (isVisible) {
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
            balance.innerHTML = <?= $getAmount ?> + " Ks";
        } else {
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
            balance.innerHTML = "••••••••• Ks";
        }

        isVisible = !isVisible;
    });

    $(document).on("click", "#btnmainwallet", function(e) {
        e.preventDefault();
        var name = $(this).data("name");
        if (name == "topup") {
            location.href = "<?= roothtml . 'wallet/topup.php' ?>";
        } else if (name == "withdraw") {
            location.href = "<?= roothtml . 'wallet/withdraw.php' ?>";
        } else {
            location.href = "<?= roothtml . 'wallet/history.php' ?>";
        }
    });


});
</script>