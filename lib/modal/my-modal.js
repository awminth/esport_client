$(document).ready(function() {    
    // Close modal
    function closeModal() {
        $(".custom-modal").fadeOut(300);
        // $("body").css("overflow", "auto");
    }
    
    $(".cancel-btn").click(closeModal);

     $(".close-modal").click(alert("ok"));
    
    // Click outside to close
    $(window).click(function(event) {
        if ($(event.target).is(".custom-modal")) {
            closeModal();
        }
    });
    
    // Escape key to close
    $(document).keydown(function(event) {
        if (event.key === "Escape" && $(".custom-modal").is(":visible")) {
            closeModal();
        }
    });
});