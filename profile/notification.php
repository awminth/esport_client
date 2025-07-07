<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>

<div class="page-header">
    <h2>Notification</h2>
</div>
<div class="login-container">
    <div class="login-card" style="display:none;">
        <h4 class="my-h" id="detail-title">IBET 789</h4>
        <p class="my-p" id="detail-desc">Where</p>
        <p class="my-p">
            <i class="fas fa-clock" style="padding-right:10px;"></i>
        </p>
    </div>
    <div class="notification-list" id="show_notification_data">

    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    function show_notification_data() {
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "show_notification_data",
            },
            success: function(data) {
                $("#show_notification_data").html(data);
            }
        });
    }
    show_notification_data();

    $(document).on('click', '.notification-item', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
    });

});
</script>