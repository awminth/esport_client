<!-- Scripts -->
<script src="<?php echo roothtml.'lib/jquery/jquery.min.js'?>"></script>
<script src="<?php echo roothtml.'lib/jquery/owl.carousel.min.js'?>"></script>
<script>
const menuToggle = document.getElementById('menuToggle');
const sideNav = document.getElementById('sideNav');
const overlay = document.getElementById('overlay');

function toggleNav() {
    const isOpen = sideNav.style.left === '0px';
    if (isOpen) {
        closeNav();
    } else {
        openNav();
    }
}

function openNav() {
    sideNav.style.left = "0";
    overlay.style.display = "block";
    menuToggle.classList.add('active');
}

function closeNav() {
    sideNav.style.left = "-260px";
    overlay.style.display = "none";
    menuToggle.classList.remove('active');
}

document.querySelectorAll('.side-nav .has-sub > a').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentElement.classList.toggle('open');
    });
});

// Initialize Owl Carousel
$(document).ready(function() {
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        // nav: true,
        // dots: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });

    $(document).on("click", "#btn_signin", function(e) {
        e.preventDefault();
        window.location.href = "<?php echo roothtml.'login/login.php'?>";
    });

    $(document).on("click", "#btn_logout", function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo roothtml.'index_action.php'?>",
            type: "POST",
            data: {
                action: "logout"
            },
            success: function(response) {
                if (response == 1) {
                    showToast({
                        type: 'success',
                        title: 'Success!',
                        message: 'Logout .... Redirect',
                        duration: 1000
                    });

                    setTimeout(function() {
                        location.href =
                            "<?php echo roothtml.'index.php' ?>";
                    }, 1000);
                }
            }
        });
    });

});
</script>

</body>

</html>