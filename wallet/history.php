<?php 
    include("../config.php"); 
    include(root.'master/header.php');
?>


<div class="page-header">
    <a href="<?=roothtml.'wallet/wallet.php'?>" class="back-icon">
        <i class="fa fa-mail-reply"></i>
    </a>
    <h2>HISTORY</h2>
</div>
<div class="login-container">
    <div class="modern-tab-container">
        <div class="modern-tab-header">
            <button class="modern-tab-btn active" data-tab="mtab1">
                <i class="fa fa-dollar"></i>
                <span>TOP-UP</span>
            </button>
            <button class="modern-tab-btn" data-tab="mtab2">
                <i class="fas fa-money-check-alt"></i>
                <span>WITHDRAW</span>
            </button>
        </div>
        <div class="modern-tab-content">
            <div id="mtab1" class="modern-tab-pane active">
                <div class="modern-withdrawal-form">
                    <div class="modern-form-group">
                        <label for="bank-account"><i class="fa fa-search"></i> Search</label>
                        <select id="search_topup">
                            <option value="1">Today</option>
                            <option value="2">Last 7 Days</option>
                            <option value="3">1 Month</option>
                            <option value="4">All</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" name="hid_search_topup" />
                <div id="show_topup_data">

                </div>
            </div>

            <!-- Tab 2 Content -->
            <div id="mtab2" class="modern-tab-pane">
                <div class="modern-withdrawal-form">
                    <div class="modern-form-group">
                        <label for="bank-account"><i class="fa fa-user"></i> Search</label>
                        <select id="search_withdraw">
                            <option value="1">Today</option>
                            <option value="2">Last 7 Days</option>
                            <option value="3">1 Month</option>
                            <option value="4">All</option>
                        </select>
                    </div>
                    <input type="hidden" name="hid_search_withdraw" />
                    <div id="show_withdraw_data">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<div id="customModal" class="custom-modal">
    <div class="modal-content modal-normal">
        <div class="modal-header bg-color-blue">
            <h3>EDIT TOP-UP DATA</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="topupkpay_edit" method="POST">
            <input type="hidden" name="action" value="edit_topup" />
            <input type="hidden" name="aid" />
            <div class="modal-body bg-color-blue">
                <div class="form-group">
                    <label for="inputField">Amount</label>
                    <i class="fas fa-funnel-dollar"></i>
                    <input type="number" name="amt" placeholder="Enter amount" required>
                </div>
                <div class="form-group">
                    <label for="inputField">Transaction Number</label>
                    <i class="fas fa-clipboard-list"></i>
                    <input type="text" name="code" placeholder="Enter transaction number" required>
                </div>
            </div>
            <div class="modal-footer bg-color-white">
                <button class="modal-btn cancel-btn">Cancel</button>
                <button type="submit" class="modal-btn confirm-btn">EDIT</button>
            </div>
        </form>
    </div>
</div>


<?php include(root.'master/footer.php'); ?>
<script>
// Tab Switching Functionality
document.querySelectorAll('.modern-tab-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Remove active class from all buttons and panes
        document.querySelectorAll('.modern-tab-btn').forEach(btn => btn.classList.remove(
            'active'));
        document.querySelectorAll('.modern-tab-pane').forEach(pane => pane.classList.remove(
            'active'));

        // Add active class to clicked button
        this.classList.add('active');

        // Show corresponding tab content
        const tabId = this.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');
    });
});

$(document).ready(function() {
    function show_topup_data() {
        var search_topup = $("[name='hid_search_topup']").val();
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'wallet/history_action.php' ?>",
            data: {
                action: "show_topup_data",
                search_topup: search_topup,
            },
            success: function(data) {
                $("#show_topup_data").html(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#show_topup_data").html(
                    '<div class="alert alert-danger">Error loading data</div>');
            }
        });
    }

    show_topup_data();

    $(document).on("change", "#search_topup", function() {
        var entryvalue = $(this).val();
        $("[name='hid_search_topup']").val(entryvalue);
        show_topup_data();
    });

    // Event delegation for dynamically loaded content
    $(document).on('click', '.collapse-header', function() {
        $(this).closest('.collapse-item').toggleClass('active');
    });

    $(document).on("click", "#btnedittopup", function(e) {
        e.preventDefault();
        var aid = $(this).data("aid");
        var amt = $(this).data("amt");
        var code = $(this).data("code");
        $("[name='aid']").val(aid);
        $("[name='amt']").val(amt);
        $("[name='code']").val(code);
        $("#customModal").fadeIn(300);
    });

    $(document).on("click", ".close-modal", function(e) {
        e.preventDefault();
        $("#customModal").fadeOut(300);
    });

    $("#topupkpay_edit").on("submit", function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        var amt = $("[name='amt']").val();
        if (Number(amt) <= 0) {
            showToast({
                type: 'warning',
                title: 'Warning!',
                message: 'Please fill amount.',
                duration: 1500
            });
            return false;
        }
        $("#customModal").fadeOut(300);
        $.ajax({
            type: "post",
            url: "<?php echo roothtml.'wallet/history_action.php' ?>",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data == 1) {
                    showToast({
                        type: 'success', 
                        title: 'Success!',
                        message: 'Edit top-up data successfully.',
                        duration: 1500 
                    });
                    show_topup_data();
                } else {
                    showToast({
                        type: 'error', 
                        title: 'Fail!',
                        message: 'Edit top-up data failed.',
                        duration: 1500 
                    });
                }
            }
        });
    });

    function show_withdraw_data() {
        var search_withdraw = $("[name='hid_search_withdraw']").val();
        $.ajax({
            type: "POST",
            url: "<?php echo roothtml.'wallet/history_action.php' ?>",
            data: {
                action: "show_withdraw_data",
                search_withdraw: search_withdraw,
            },
            success: function(data) {
                $("#show_withdraw_data").html(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
                $("#show_withdraw_data").html(
                    '<div class="alert alert-danger">Error loading data</div>');
            }
        });
    }

    show_withdraw_data();

    $(document).on("change", "#search_withdraw", function() {
        var entryvalue = $(this).val();
        $("[name='hid_search_withdraw']").val(entryvalue);
        show_withdraw_data();
    });


});
</script>