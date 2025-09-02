<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <a href="<?=roothtml.'profile/mypoints.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>Quiz Detail</h2>
</div>
<div class="quiz-container">
    <div class="quiz-card">
        <form id="show_quiz_detail" method="POST">

        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
$(document).ready(function() {

    function show_quiz_data() {
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'profile/mainprofile_action.php' ?>",
            data: {
                action: "show_quiz_detail"
            },
            success: function(data) {
                $("#show_quiz_detail").html(data);
            }
        });
    }
    show_quiz_data();

});
</script>