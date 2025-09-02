<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <a href="<?=roothtml.'profile/mypoints.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>Quiz</h2>
</div>
<div class="quiz-container">
    <div class="quiz-card">
        <form id="frmquiz" method="POST">

        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {
    function quiz_assignment() {
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "quiz_assign"
            },
            success: function(data) {
            }
        });
    }
    quiz_assignment();

    function show_quiz_data() {
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "show_quiz"
            },
            success: function(data) {
                $("#frmquiz").html(data);
            }
        });
    }
    show_quiz_data();

    $("#frmquiz").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
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
                        message: 'Quiz successful!',
                        duration: 1500
                    });
                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'profile/mypoints.php' ?>";
                    }, 1500);
                } else if (data == 0) {
                    showToast({
                        type: 'info',
                        title: 'Information!',
                        message: 'Quiz failed.',
                        duration: 1500
                    });
                } else {
                    showToast({
                        type: 'error',
                        title: 'Error!',
                        message: 'Quiz failed : ' + data,
                        duration: 1500
                    });
                }
            }
        });
    });

});
</script>