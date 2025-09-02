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
    <h2>Wallet</h2>
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
                            <i id="messageMain" class="fas fa-exclamation-triangle"
                                style="padding-left:10px;color:cyan;"></i>
                        </span>
                        <div class="wallet-balance-display">
                            <span class="wallet-currency"></span>
                            <span class="wallet-amount" id="mainWalletBalance">........</span>
                            <span class="balance-toggle" id="toggleMainWalletBalance">
                                <i class="fas fa-eye-slash" id="mainEyeIcon"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button id="btnwallet_transfer" class="wallet-action-btn primary-btn">
                    ADD <i class="fas fa-exchange-alt"></i>
                </button>
            </div>

            <div class="wallet-divider"></div>
            <div class="wallet-section game-wallet-section">
                <div class="wallet-info">
                    <div class="wallet-icon">
                        <i class="fas fa-gamepad"></i>
                    </div>
                    <div class="wallet-details">
                        <span class="wallet-name">Game Wallet
                            <i id="messageGame" class="fas fa-exclamation-triangle"
                                style="padding-left:10px;color:cyan;"></i>
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
                <button id="btnwallet_transfer" class="wallet-action-btn primary-btn">
                    ADD <i class="fas fa-exchange-alt"></i>
                </button>
            </div>
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

<!-- The Modal -->
<div id="warningmodal" class="custom-modal">
    <div class="modal-content modal-normal">
        <div class="modal-header bg-color-blue">
            <h3>Warning!</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="" method="POST">
            <div class="modal-body bg-color-blue">
                <p class="my-p">
                    You cannot withdraw yet because your Bonus Amount is still less than the amount you have wagered.
                </p>
            </div>
            <div class="modal-footer bg-color-white">
                <button class="modal-btn cancel-btn">Close</button>
            </div>
        </form>
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

    $(document).on("click", "#btnmainwallet", function(e) {
        e.preventDefault();
        var name = $(this).data("name");
        if (name == "topup") {
            location.href = "<?= roothtml . 'wallet/topup.php' ?>";
        } else if (name == "withdraw") {
            $.ajax({
                type: "POST",
                url: "<?= roothtml.'wallet/wallet_action.php'?>",
                data: {
                    action: "withdrawcheck"
                },
                success: function(data) {
                    if (data == 1) {
                        location.href = "<?= roothtml . 'wallet/withdraw.php' ?>";
                    } 
                    else if(data == 2){
                        location.href = "<?= roothtml . 'wallet/withdraw.php' ?>";
                    }
                    else{
                        $("#warningmodal").show();
                    }
                }
            });
        } else {
            location.href = "<?= roothtml . 'wallet/history.php' ?>";
        }
    });

    $(document).on("click", "#btnwallet_transfer", function(e) {
        e.preventDefault();
        var name = $(this).data("name");
        location.href = "<?= roothtml . 'wallet/wallet_transfer.php' ?>";
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
        window.location.reload();
    });


});
</script>