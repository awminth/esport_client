<?php 
    include("config.php"); 
    include(root."master/header.php");
?>

<!-- scrolling text -->
<div class="scrolling-text-container">
    <p class="scrolling-text">Welcome to <strong>HITUPMM</strong></p>
</div>
<!-- Carousel Section -->
<div class="carousel-container">
    <h2 class="carousel-title">TODAY MATCHS</h2>
    <div class="owl-carousel owl-theme">
        <?php
        $sql = "SELECT * FROM tblsiteheader";
        $result = $con->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $img_url = roothtml_admin.'lib/images/'.$row['Img'];

                $max_length = 180;
                if (mb_strlen($row['Description'], 'UTF-8') > $max_length) {
                    $short = mb_substr($row['Description'], 0, $max_length, 'UTF-8') . ' . . . . .';
                } else {
                    $short = $row['Description'];
                }
        ?>
        <div class="item">
            <img src="<?php echo $img_url; ?>" alt="Slide 1" class="carousel-img">
            <h3 class="carousel-item-title"><?=$row["Title"]?></h3>
            <p class="carousel-item-desc">
                <?php echo $short; ?>
                <a href="#" id="btncontinue" data-title="<?=$row["Title"]?>" data-desc="<?=$row["Description"]?>"
                    data-img="<?=$img_url?>" data-dt="<?=$row["DT"]?>">
                    Continue
                </a>
            </p>
            <p class="carousel-item-span">
                <i class="fas fa-clock" style="padding-right:10px;"></i>
                <?=enDate1($row['DT'])?> - <?=enTime($row['DT'])?>
            </p>
        </div>
        <?php 
            }
        }
        ?>
    </div>
</div>

<h2 class="carousel-title" style="padding-top:20px;">WHAT GAME DO YOU WANT TO PLAY? </h2>
<div class="card-container">
    <div class="card" id="ibet" style="cursor:pointer;">
        <img src="<?php echo roothtml.'lib/img/ibet789.jpg'?>" alt="Card 1">
        <div class="card-label">IBET 789</div>
    </div>

    <div class="card" id="sporttwo" style="cursor:pointer;">
        <img src="<?php echo roothtml.'lib/img/afb.jpg'?>" alt="Card 2">
        <div class="card-label">LIVE CASINO</div>
    </div>
</div>

<h2 class="carousel-title" style="padding-top:20px;">WHY US? </h2>
<div class="benefit-card">
    <i class="fas fa-check-circle"></i>
    <h3>EASY TO BET</h3>
    <p>Also note that if you change the font-size or color of the icon's
        container, the icon changes. Same things goes for shadow, and anything
        Also note that if you change the font-size or color of the icon's
        container, the icon changes. Same things goes for shadow, and anything
        Also note that if you change the font-size or color of the icon's
        container, the icon changes. Same things goes for shadow, and anything</p>
</div>

<!-- The Modal -->
<div id="continueModal" class="custom-modal">
    <div class="modal-content modal-big">
        <div class="modal-header bg-color-blue">
            <h3>Match Detail</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body bg-color-blue">
            <img src="<?php echo roothtml.'lib/img/ibet789.jpg'?>" alt="Card 1" class="my-i" id="detail-img">
            <h4 class="my-h" id="detail-title">IBET 789</h4>
            <p class="my-p" id="detail-desc">Where</p>
            <p class="my-p">
                <i class="fas fa-clock" style="padding-right:10px;"></i>
                <span id="detail-dt"></span>
            </p>
        </div>
    </div>
</div>

<?php include(root."master/footer.php"); ?>
<script>
$(document).ready(function() {

    $(document).on("click", "#sporttwo", function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml . 'index_action.php' ?>",
            data: {
                action: 'sportlogin',
                portfolio: 'Seamlessgame',
                gpid: 1024
            },
            success: function(data) {
                try {
                    // Parse JSON response
                    var jsonData = typeof data === "string" ? JSON.parse(data) : data;

                    if (jsonData.status === "success") {
                        let redirectUrl = jsonData.redirect_url;
                        // // Redirect to the login URL
                        window.location.href =
                            "<?= roothtml . 'pages/livecasino.php' ?>" +
                            "?target_url=" + encodeURIComponent(redirectUrl);
                    } else if (data == 404) {
                        location.href = "<?= roothtml . 'login/login.php' ?>";
                    } else {
                        console.log("Error data", jsonData);
                        showToast({
                            type: 'error',
                            title: 'Error!',
                            message: 'Login Failed!',
                            duration: 2000
                        });
                    }
                } catch (err) {
                    console.error("Invalid JSON:", err, data);
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Unexpected server response!',
                        duration: 2000
                    });
                }
            },
            error: function() {
                showToast({
                    type: 'error',
                    title: 'Error!',
                    message: 'Server error occurred!',
                    duration: 2000
                });
            }
        });
    });

    $(document).on("click", "#ibet", function(e) {
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "<?php echo roothtml . 'index_action.php' ?>",
            data: {
                action: 'ibetlogin'
            },
            success: function(data) {
                try {
                    // Parse JSON response
                    var jsonData = typeof data === "string" ? JSON.parse(data) : data;

                    if (jsonData.status === "success") {
                        let redirectUrl = jsonData.redirect_url;

                        // Redirect to the login URL
                        window.location.href =
                            "<?= roothtml . 'pages/ibettest.php' ?>" +
                            "?target_url=" + encodeURIComponent(redirectUrl);
                    } else if (data == 404) {
                        location.href = "<?= roothtml . 'login/login.php' ?>";
                    } else {
                        console.log("Error data", jsonData);
                        showToast({
                            type: 'error',
                            title: 'Error!',
                            message: 'Login Failed!',
                            duration: 2000
                        });
                    }
                } catch (err) {
                    console.error("Invalid JSON:", err, data);
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Unexpected server response!',
                        duration: 2000
                    });
                }
            },
            error: function() {
                showToast({
                    type: 'error',
                    title: 'Error!',
                    message: 'Server error occurred!',
                    duration: 2000
                });
            }
        });
    });

    $(document).on("click", "#btncontinue", function(e) {
        e.preventDefault();
        var title = $(this).data("title");
        var desc = $(this).data("desc");
        var img = $(this).data("img");
        var dt = $(this).data("dt");
        $('#detail-img').attr('src', img);
        $("#detail-title").text(title);
        $("#detail-desc").text(desc);
        $("#detail-dt").text(dt);
        $("#continueModal").fadeIn(300);
    });

    $(document).on("click", ".close-modal", function(e) {
        e.preventDefault();
        $("#continueModal").fadeOut(300);
    });

});
</script>