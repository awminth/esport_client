<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>
<style>
    .iframe-container {
        width: 100vw;
      height: 100vh;
        overflow: hidden;
        position: relative;
        border: 1px solid #ddd;
    }

    #myIframe {
        width: 100vw;
      height: 100vh;
        border: none;
        overflow: hidden;
    }
</style>
<!-- <div class="quiz-container"> -->
    <?php
        // ခွင့်ပြုထားတဲ့ domain စာရင်း
        $allowedDomains = [
            '568win.com',
            'ex-api-demo-yy.568win.com',
            'ggppqqgg.com',
            'sports-demo.ggppqqgg.com', // သင်သုံးနေတဲ့ domain
            'lmd-uat.gaolitsai.com'      // သင်ထည့်လိုတဲ့ အသစ် domain
        ];

        // target_url parameter ရှိမရှိစစ်တယ်
        if (isset($_GET['target_url'])) {
            $url = $_GET['target_url'];

            // URL တန်ဖိုး တကယ်တော့ တရားဝင်တာလား စစ်တယ်
            if (!filter_var($url, FILTER_VALIDATE_URL)) {
                echo "<p>Invalid URL provided.</p>";
                exit;
            }

            // URL ကနေ host(domain) ကို ဖယ်ထုတ်တယ်
            $parsedUrl = parse_url($url);
            $host = $parsedUrl['host'] ?? '';

            // domain ခွင့်ပြုထားတာလား စစ်တယ်
            if (in_array($host, $allowedDomains)) {
                // XSS ကာကွယ်ဖို့အတွက် URL ကို escape လုပ်တယ်
                $safeUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

                // iframe ပြသတယ်
                echo '
                <div class="iframe-container">
                    <iframe id="myIframe" src="'.$safeUrl.'" 
                        sandbox="allow-same-origin allow-scripts allow-popups allow-forms allow-presentation"
                        scrolling="yes"
                        referrerpolicy="no-referrer"
                        allowfullscreen>
                    </iframe>
                </div>';
            } else {
                echo "<p>This URL is not allowed to be shown in an iframe.</p>";
            }
        } else {
            echo "<p>No target URL provided.</p>";
        }
    ?>
<!-- </div> -->


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    const entries = performance.getEntriesByType("navigation");
    if (entries.length > 0 && entries[0].type === "reload") {
        var username = "<?php echo $_SESSION['esportclient_username'] ?>";
        var password = "<?php echo $_SESSION['esportclient_userpassword'] ?>";
        var portfolio = "<?php echo $_SESSION['esportclient_portfolio'] ?>";
        var gpid = "<?php echo $_SESSION['esportclient_gpid'] ?>";

        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'index_action.php' ?>",
            data: {
                action: 'sportlogin',
                portfolio: portfolio,
                gpid: gpid
            },
            success: function(data) {
                try {
                    // Parse JSON response
                    var jsonData = typeof data === "string" ? JSON.parse(data) : data;

                    if (jsonData.status === "success") {
                        let redirectUrl = jsonData.redirect_url;

                        // Redirect to the login URL
                        window.location.href = "<?= roothtml.'pages/livecasino.php'?>" +
                            "?target_url=" + encodeURIComponent(redirectUrl);
                    } else if (data == 404) {
                        location.href = "<?=roothtml.'login/login.php'?>";
                    } else {
                        console.log("Error data", jsonData);
                        swal("Error", "Login failed", "error");
                    }
                } catch (err) {
                    console.error("Invalid JSON:", err, data);
                    swal("Error", "Unexpected server response", "error");
                }
            },
            error: function() {
                swal("Error", "Server error occurred", "error");
            }
        });
    }

});
</script>