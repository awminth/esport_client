<?php 
    include("../config.php"); 
    include(root.'master/header.php');

    $points = GetInt("SELECT Points FROM tblpoints WHERE PlayerID = ?", [$_SESSION["esportclient_userid"]]);
?>


<section class="bg-dark-blue">
    <div class="m-12 center-content t-box-dark-blue">
        <div class="page-header">
            <h2>MY POINTS</h2>
        </div>
        <div class="login-container">
            <div class="login-card">
                <div class="point-box">
                    <p id="btnmypoint" data-pts="<?=$points?>">
                        <i class="fas fa-crown"></i> <?=$points?> Points
                    </p>
                </div>
                <div class="point-group">
                    <label>You can earn bonus points by answering
                        weekly questions.
                    </label>
                    <a href="<?php echo roothtml.'profile/quiz.php'?>">
                        <i class="fas fa-hand-point-right"></i>NOW QUIZ</a>
                </div>
                <div class="point-noti">
                    <i class="fas fa-award" style="font-size:25px;color:#ffe10a;padding-right:5px;"></i>
                    Points can be exchanged at the rate of <?= $exchange_amt?> kyats per point.
                </div>
                <h4 style="color:white;padding:10px;">Quiz Detail</h4>
                <div id="go_quiz_detail">

                </div>
            </div>
        </div>
    </div>
</section>

<!-- The Modal -->
<div id="pointModal" class="custom-modal">
    <div class="modal-content modal-normal">
        <div class="modal-header bg-color-blue">
            <h3>Exchange Points</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="frmexchangepoint" method="POST">
            <input type="hidden" name="action" value="exchange_point" />
            <input type="hidden" name="hid_pts" />
            <div class="modal-body bg-color-blue">
                <div class="point-noti">
                    <div class="rating-row">
                        <label class="rating-label" for="cs1-star5">Deposit/Withdrawal – Fast or Not Fast</label>
                        <div class="stars">
                            <input type="radio" id="cs1-star5" name="rating_one" value="5"><label
                                for="cs1-star5">★</label>
                            <input type="radio" id="cs1-star4" name="rating_one" value="4"><label
                                for="cs1-star4">★</label>
                            <input type="radio" id="cs1-star3" name="rating_one" value="3"><label
                                for="cs1-star3">★</label>
                            <input type="radio" id="cs1-star2" name="rating_one" value="2"><label
                                for="cs1-star2">★</label>
                            <input type="radio" id="cs1-star1" name="rating_one" value="1"><label
                                for="cs1-star1">★</label>
                        </div>
                    </div>
                    <div class="rating-row">
                        <label class="rating-label" for="cs2-star5">Customer Service</label>
                        <div class="stars">
                            <input type="radio" id="cs2-star5" name="rating_two" value="5"><label
                                for="cs2-star5">★</label>
                            <input type="radio" id="cs2-star4" name="rating_two" value="4"><label
                                for="cs2-star4">★</label>
                            <input type="radio" id="cs2-star3" name="rating_two" value="3"><label
                                for="cs2-star3">★</label>
                            <input type="radio" id="cs2-star2" name="rating_two" value="2"><label
                                for="cs2-star2">★</label>
                            <input type="radio" id="cs2-star1" name="rating_two" value="1"><label
                                for="cs2-star1">★</label>
                        </div>
                    </div>
                    <div class="rating-row">
                        <label class="rating-label" for="cs3-star5">Give Cashback / Don't Give Cashback</label>
                        <div class="stars">
                            <input type="radio" id="cs3-star5" name="rating_three" value="5"><label
                                for="cs3-star5">★</label>
                            <input type="radio" id="cs3-star4" name="rating_three" value="4"><label
                                for="cs3-star4">★</label>
                            <input type="radio" id="cs3-star3" name="rating_three" value="3"><label
                                for="cs3-star3">★</label>
                            <input type="radio" id="cs3-star2" name="rating_three" value="2"><label
                                for="cs3-star2">★</label>
                            <input type="radio" id="cs3-star1" name="rating_three" value="1"><label
                                for="cs3-star1">★</label>
                        </div>
                    </div>
                </div>
                <div class="point-noti">
                    <i class="fas fa-award" style="font-size:25px;color:#ffe10a;padding-right:5px;"></i>
                    Points can be exchanged at the rate of <?=$exchange_amt?> kyats per point.
                    <br><br>
                    <i class="fas fa-bell" style="font-size:25px;color:#ffe10a;padding-right:5px;"></i>
                    You can exchange points starting from a <strong style="color:red;">minimum of 20 </strong>.
                </div>
                <div class="point-noti">
                    <i class="fas fa-award" style="font-size:25px;color:red;padding-right:5px;"></i>
                    Your Exchangeable Points :
                    <span id="hid_pts" style="font-size:27;color:red;padding-left:15px;"></span>
                </div>
                <div class="form-group">
                    <label for="inputField">How many points you exchange?</label>
                    <i class="fas fa-clipboard-list"></i>
                    <input type="number" name="pts" placeholder="Enter points" required>
                </div>
            </div>
            <div class="modal-footer bg-color-white">
                <button class="modal-btn cancel-btn">Cancel</button>
                <button type="submit" class="modal-btn confirm-btn">EXCHANGE</button>
            </div>
        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    function go_quiz_detail() {
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "go_quiz_detail",
            },
            success: function(data) {
                $("#go_quiz_detail").html(data);
            }
        });
    }
    go_quiz_detail();

    $(document).on("click", "#btn_godetail", function(e) {
        e.preventDefault();
        var vno = $(this).data("vno");
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "go_detail",
                vno: vno
            },
            success: function(data) {
                if (data == 1) {
                    location.href = "<?php echo roothtml.'profile/quiz_detail.php' ?>";
                }
            }
        });
    });

    $(document).on("click", "#btnmypoint", function(e) {
        e.preventDefault();
        var pts = $(this).data("pts");
        $("[name='hid_pts']").val(pts);
        $("#hid_pts").text(pts);
        $("#pointModal").fadeIn(300);
    });

    $(document).on("click", ".close-modal, .cancel-btn", function(e) {
        e.preventDefault();
        $("#pointModal").fadeOut(300);
    });

    $("#frmexchangepoint").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var pts = $("[name='pts']").val();
        var hid_pts = $("[name='hid_pts']").val();
        if (Number(pts) <= 0) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please fill ecchange point.',
                duration: 2000
            });
            return false;
        }
        if (Number(pts) < 20) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'You can exchange points starting from a minimum of 20.',
                duration: 2000
            });
            return false;
        }
        if (Number(pts) > Number(hid_pts)) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Your point not enough for exchange.',
                duration: 2000
            });
            return false;
        }
        $("#pointModal").fadeOut(300);
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Exchange points successfully.',
                        duration: 1500
                    });
                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'error',
                        title: 'Fail!',
                        message: 'Exchange point failed.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Fail!',
                        message: 'Exchange point error.' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>