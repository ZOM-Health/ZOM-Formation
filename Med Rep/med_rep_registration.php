<!--include css-->
<?php include 'inc/includes_top.php'; ?>

<body class="med-rep-background login-page login-form-fall" style="background: url('<?php echo base_url('assets/yazom/img/med_rep_registration.svg'); ?>');">

<!--include menu-->
<?php include 'inc/main_nav.php'; ?>

<!-- Begin page content -->
<section role="main" id="med_rep_reg_section" class="container-fluid">
    <div class="col-md-6 col-md-offset-6">
        <div class="yazom-card" id="med-rep-reg-form">
            <div class="box">

                <div class="logo">
                    <img src="<?php echo base_url('assets/yazom/img/zom_logo.png'); ?>" alt="YAZOM">
                </div>

                <h2 class="sign-in">Med Rep Registration</h2>

                <form method="POST" role="form" id="med_rep_registration" novalidate="novalidate">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="input-label">First Name</label>
                            <input type="text" class="form-control yazom-input" name="first_name" id="first_name" placeholder="First Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-label">Last Name</label>
                            <input type="text" class="form-control yazom-input" name="last_name" id="last_name" placeholder="Last Name">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-6">
                            <label class="input-label">Country Of Origin</label>
                            <select class="form-control yazom-input" name="origin_country" id="origin_country">
                                <option value="">Country of Origin</option>
                                <?php foreach ($countries as $c) { ?>
                                    <option value="<?php echo $c["id"]; ?>"><?php echo $c["name"]; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="input-label">Email</label>
                            <input type="text" class="form-control yazom-input" name="email" id="email" placeholder="Email">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label class="input-label">Ethereum Wallet Address</label>
                            <input type="text" class="form-control yazom-input" name="wallet_address" id="wallet_address" placeholder="Separate wallet addresses with commas where necessary.">
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-6">
                            <label class="input-label">Have you completed KYC Verification?</label>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label class="custom-radio">
                                <input type="radio" name="kyc_verification" value="1">
                                <span class="check-mark"></span>
                                <span class="radio-text">Yes</span>
                            </label>       
                            <label class="custom-radio">
                                <input type="radio" name="kyc_verification" value="0" checked>
                                <span class="check-mark"></span>
                                <span class="radio-text">No</span>
                            </label>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-6">
                            <label class="input-label">I have read and agree to the <a target="_blank" href="<?php echo base_url('index.php?login/node_terms/'); ?>">Terms and Conditions</a></label>
                        </div>
                        <div class="form-group col-md-6 text-right">
                            <label class="custom-radio">
                                <input type="radio" name="read_terms" value="1">
                                <span class="check-mark"></span>
                                <span class="radio-text">Yes</span>
                            </label>       
                            <label class="custom-radio">
                                <input type="radio" name="read_terms" value="0" checked>
                                <span class="check-mark"></span>
                                <span class="radio-text">No</span>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="registration" class="btn sign-in-btn btn-block btn-login">Complete Registration</button>
                    </div>
                    <div class="form-group col-md-12 text-center">
                        <span class="med-rep-reg-success success-msg"></span>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<!--include js-->
<?php include 'inc/includes_bottom.php'; ?>

<script type="application/javascript">
    var isMobile = false;
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini|Opera Mobile|Kindle|Windows Phone|PSP|AvantGo|Atomic Web Browser|Blazer|Chrome Mobile|Dolphin|Dolfin|Doris|GO Browser|Jasmine|MicroB|Mobile Firefox|Mobile Safari|Mobile Silk|Motorola Internet Browser|NetFront|NineSky|Nokia Web Browser|Obigo|Openwave Mobile Browser|Palm Pre web browser|Polaris|PS Vita browser|Puffin|QQbrowser|SEMC Browser|Skyfire|Tear|TeaShark|UC Browser|uZard Web|wOSBrowser|Yandex.Browser mobile/i.test(navigator.userAgent)) isMobile = true;
    $(document).ready(function () {

        $("#med_rep_registration").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                origin_country: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                wallet_address: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: "What is your email?",
                    email: "Please enter a valid email address.",
                },
                wallet_address: "Enter your ethereum wallet address here.",
            },
            errorPlacement: function (error, element) {
                element.attr('data-original-title', error.text());
                $('.error').tooltip({
                    placement: isMobile ? "top" : "left",
                    trigger: "focus"
                });
            },
            success: function (element) {
                $('.valid').tooltip('hide');
            }
        });

        //Click to save button an user Register
        $(document).off("click", "#registration").on('click', "#registration", function () {
            var ele = $(this);
            if ($("#med_rep_registration").valid()) {
                $.ajax({
                    data: $("#med_rep_registration").serialize(),
                    url: "<?php echo base_url(); ?>index.php?login/med_rep_registration/",
                    type: 'POST',
                    dataType: 'json',
                    beforeSend: function () {
                        $(".error").html("");
                        $(".success-msg").html("");
                        ele.prop("disabled", true);
                        ele.html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                    },
                    success: function (result) {
                        ele.prop("disabled", false);
                        ele.html('Complete Registration');
                        if (result['success'] === true) {
                            $(".success-msg").html('<img src="<?php echo base_url("assets/yazom/img/icon/check.svg"); ?>">&nbsp;' + result['message']);
                            $('#med_rep_registration')[0].reset();
                        } else if (result['error'] === true) {
                            $(".success-msg").html('<img src="<?php echo base_url("assets/yazom/img/icon/stop.svg"); ?>">&nbsp;' + result['message']);
                        } else if (result['exists'] === true) {
                            $(".success-msg").html('<img src="<?php echo base_url("assets/yazom/img/icon/stop.svg"); ?>">&nbsp;' + result['message']);
                        }
                    },
                    error: function (xhr, status, error) {
                        alert("Something went wrong! Please refresh the page.");
                    }
                });
            }
        });

    });
</script>
