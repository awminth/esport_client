<?php
    include("../config.php");
    include(root.'master/header.php');

    $player_name = $_SESSION["esportclient_username"] ?? null; 

    $getAmount = GetInt("SELECT Balance FROM tblplayer WHERE UserName = ?", [$player_name]);
    
    $ibetResult = callIbetAPI("http://apisbjstest_bro777.gksic5ousjiw9pldk3apx6dmbte.com/GetAccountBalance",[
        "secret" => $secretID,
        "agent" => $agent,
        "userName" => $player_name
    ]);

    if($ibetResult["errorCode"] === ""){
        $ibetAmount = $ibetResult["balance"];
    }else{
        $ibetAmount = 0;
    }

?>

<div class="page-header">
    <a href="<?=roothtml.'wallet/wallet.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>Transfer Wallet</h2>
</div>
<div class="login-container">
    <div class="login-card">
        <div class="modern-wallet-card-container">
            <div class="wallet-section main-wallet-section">
                <div class="wallet-info">
                    <div class="wallet-icon">
                        <i class="fas fa-wallet"></i>
                    </div>
                    <div class="wallet-details">
                        <span class="wallet-name">Main Wallet
                            <i id="messageMain" class="fas fa-exclamation-triangle" style="padding-left:25px;color:cyan;"></i></span>
                        <div class="wallet-balance-display">
                            <span class="wallet-currency"></span>
                            <span class="wallet-amount" id="mainWalletBalance">........</span>
                            <span class="balance-toggle" id="toggleMainWalletBalance">
                                <i class="fas fa-eye-slash" id="mainEyeIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wallet-divider"></div>
            <div class="wallet-section game-wallet-section">
                <div class="wallet-info">
                    <div class="wallet-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="wallet-details">
                        <span class="wallet-name">Game Wallet
                            <i id="messageGame" class="fas fa-exclamation-triangle" style="padding-left:25px;color:cyan;"></i>
                        </span>
                        <div class="wallet-balance-display">
                            <span class="wallet-currency"></span>
                            <span class="wallet-amount" id="gameWalletBalance">........</span>
                            <span class="balance-toggle" id="toggleGameWalletBalance">
                                <i class="fas fa-eye-slash" id="gameEyeIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modern-transfer-card-container">
            <div class="transfer-direction-selector">
                <label class="radio-card" id="chkwallettype">
                    <input type="radio" name="transferDirection" value="mainToGame" checked>
                    <span class="radio-content">
                        <!-- <span class="radio-label">From</span> -->
                        <div class="wallet-display-group">
                            <i class="fas fa-wallet wallet-icon-sm from-icon"></i>
                            <span class="wallet-text">Main Wallet</span>
                            <i class="fas fa-arrow-right transfer-arrow"></i>
                            <i class="fas fa-gamepad wallet-icon-sm to-icon"></i>
                            <span class="wallet-text">Game Wallet</span>
                        </div>
                    </span>
                </label>
                <label class="radio-card" id="chkwallettype">
                    <input type="radio" name="transferDirection" value="gameToMain">
                    <span class="radio-content">
                        <!-- <span class="radio-label">From</span> -->
                        <div class="wallet-display-group">
                            <i class="fas fa-gamepad wallet-icon-sm from-icon"></i>
                            <span class="wallet-text">Game Wallet</span>
                            <i class="fas fa-arrow-right transfer-arrow"></i>
                            <i class="fas fa-wallet wallet-icon-sm to-icon"></i>
                            <span class="wallet-text">Main Wallet</span>
                        </div>
                    </span>
                </label>
            </div>
            <div class="amount-input-group">
                <label for="transferAmount" class="input-label">Transfer Amount</label>
                <div class="input-wrapper">
                    <input type="number" name="transferAmount" class="styled-input" placeholder="0">
                </div>
            </div>
            <input type="hidden" name="hidden_transfer" value="mainToGame" />
            <button class="btn-liquid btnname" id="btnconfirmTransfer">Transfer to Game Wallet</button>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="messageModal" class="custom-modal">
    <div class="modal-content modal-normal">
        <div class="modal-header bg-color-blue">
            <h3>Transfer Note</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body bg-color-blue">
            <h4 class="my-h" id="msg_title"></h4>
            <p class="my-p" id="msg_desc"></p>
        </div>
    </div>
</div>

<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    // for main wallet
    let isVisibleMain = true;
    document.getElementById("toggleMainWalletBalance").addEventListener("click", function() {
        const icon = document.getElementById("mainEyeIcon");
        const balance = document.getElementById("mainWalletBalance");

        if (isVisibleMain) {
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
            balance.innerHTML = <?= $getAmount ?>;
        } else {
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
            balance.innerHTML = "•••••••••";
        }

        isVisibleMain = !isVisibleMain;
    });

    // for game wallet
    let isVisibleGame = true;
    document.getElementById("toggleGameWalletBalance").addEventListener("click", function() {
        const icon = document.getElementById("gameEyeIcon");
        const balance = document.getElementById("gameWalletBalance");

        if (isVisibleGame) {
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
            balance.innerHTML = <?= $ibetAmount ?>;
        } else {
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
            balance.innerHTML = "•••••••••";
        }

        isVisibleGame = !isVisibleGame;
    });

    $(document).on("click", "#chkwallettype", function(e) {
        e.preventDefault();
        var $radioInput = $(this).find('input[type="radio"]');
        $radioInput.prop('checked', true);
        var selectedValue = $radioInput.val();
        if (selectedValue == "mainToGame") {
            $("[name='hidden_transfer']").val(selectedValue);
            $(".btnname").text("Transfer to Game Wallet");
        } else {
            $("[name='hidden_transfer']").val(selectedValue);
            $(".btnname").text("Transfer to Main Wallet");
        }
    });

    $(document).on("click", "#messageMain", function(e) {
        e.preventDefault();
        $("#msg_title").html("You can use Main Wallet as -");
        $("#msg_desc").html(
            "<i class='fas fa-play-circle' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; Live Casino <br>" +
            "<i class='fas fa-exchange-alt' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; Transfer to Game Wallet <br>" +
            "<i class='fas fa-shopping-bag' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; Deposit <br>" +
            "<i class='fas fa-money-check-alt' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; Withdraw <br>" 
        );
        $("#messageModal").fadeIn(300);
    });

    $(document).on("click", "#messageGame", function(e) {
        e.preventDefault();
        $("#msg_title").html("You can use Game Wallet on -");
        $("#msg_desc").html(
            "<i class='fas fa-play-circle' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; ibet 789 <br>" +
            "<i class='fas fa-exchange-alt' style='color:cyan;'></i>&nbsp;&nbsp;&nbsp; Transfer to Main Wallet <br>"
        );
        $("#messageModal").fadeIn(300);
    });

    $(document).on("click", ".close-modal", function(e) {
        e.preventDefault();
        $("#messageModal").fadeOut(300);
    });

    $(document).on("click", "#btnconfirmTransfer", function(e) {
        e.preventDefault();
        var result = $("[name='hidden_transfer']").val();
        var transferAmount = $("[name='transferAmount']").val();
        if (Number(transferAmount) < 0 || Number(transferAmount) == "") {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please fill transfer amount.',
                duration: 1500
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'wallet/wallet_action.php'; ?>",
            data: {
                action: "transfer_wallet",
                result: result,
                transferAmount: transferAmount,
            },
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Transfer successful! Redirecting....',
                        duration: 1500
                    });
                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'wallet/wallet.php' ?>";
                    }, 1000);
                } else if (data == 0) {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Transfer error.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Transfer failed : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>