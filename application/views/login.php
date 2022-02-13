

<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 9 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" >
    <!--begin::Head-->
    <head><base href="../../../">
        <meta charset="utf-8"/>
        <title>Queen Gallerry | Login</title>
        <meta name="description" content="Login page example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->


                    <!--begin::Page Custom Styles(used by this page)-->
                             <link href="<?php echo base_url(); ?>dist/assets/css/pages/login/login-1.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                        <!--end::Page Custom Styles-->

        <!--begin::Global Theme Styles(used by all pages)-->
                    <link href="<?php echo base_url(); ?>dist/assets/plugins/global/plugins.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="<?php echo base_url(); ?>dist/assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                    <link href="<?php echo base_url(); ?>dist/assets/css/style.bundle.css?v=7.0.6" rel="stylesheet" type="text/css"/>
                <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->

<link href="<?php echo base_url(); ?>dist/assets/css/themes/layout/header/base/light.css?v=7.0.6" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>dist/assets/css/themes/layout/header/menu/light.css?v=7.0.6" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>dist/assets/css/themes/layout/brand/dark.css?v=7.0.6" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>dist/assets/css/themes/layout/aside/dark.css?v=7.0.6" rel="stylesheet" type="text/css"/>        <!--end::Layout Themes-->

        <link rel="shortcut icon" href="<?php echo base_url(); ?>dist/assets/media/logos/favicon.ico"/>

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >

    	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
<div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
    <!--begin::Aside-->
    <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #F2C98A;">
        <!--begin::Aside Top-->
        <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
            <!--begin::Aside header-->
            <a href="#" class="text-center mb-10">
				<img src="<?php echo base_url(); ?>dist/assets/media/logos/logo-letter-1.png" class="max-h-70px" alt=""/>
			</a>
            <!--end::Aside header-->

            <!--begin::Aside title-->
            <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #986923;">
                FLOWERS ARE<br/>
                HAPPY THINGS
            </h3>
            <!--end::Aside title-->
        </div>
        <!--end::Aside Top-->

        <!--begin::Aside Bottom-->
        <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(assets/media/svg/illustrations/login-visual-1.svg)"></div>
        <!--end::Aside Bottom-->
    </div>
    <!--begin::Aside-->

    <!--begin::Content-->
    <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
        <!--begin::Content body-->
        <div class="d-flex flex-column-fluid flex-center">
            <!--begin::Signin-->
            <div class="login-form login-signin">
                <!--begin::Form-->
                <form action="<?= base_url('login') ?>"   method="POST" >
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Welcome to Queen Gallery</h3>
                       
                    </div>
                    <div class="row">
                    <?= $this->session->flashdata('message'); ?>
                    
                    </div>
                    <!--begin::Title-->
                    <!--begin::Form group-->
                    <div class="form-group">
                        <label class="font-size-h6 font-weight-bolder text-dark">Username</label>
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="text" name="nama_user" autofocus autocomplete="off"/>
                        <!-- <?= form_error ('username','<small class="text-danger pl-3">','</small>'); ?></div> -->
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <div class="d-flex justify-content-between mt-n5">
                            <label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
                            <!-- <?= form_error ('password','<small class="text-danger pl-3">','</small>'); ?></div> -->
                            <!-- <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">
        						Forgot Password ?
        					</a> -->
                        </div>

                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg" type="password" name="password" autocomplete="off"/>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Action-->
                    <div class="pb-lg-0 pb-5">
                        <button type="submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">Sign In</button>

                      
                    </div>
                    <!--end::Action-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Signin-->

           

            <!--begin::Forgot-->
            <div class="login-form login-forgot">
                <!--begin::Form-->
                <form class="form" novalidate="novalidate" id="kt_login_forgot_form">
                    <!--begin::Title-->
                    <div class="pb-13 pt-lg-0 pt-5">
                        <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                        <p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
                    </div>
                    <!--end::Title-->

                    <!--begin::Form group-->
                    <div class="form-group">
                        <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off"/>
                    </div>
                    <!--end::Form group-->

                    <!--begin::Form group-->
                    <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="button" id="kt_login_forgot_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                        <button type="button" id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                    </div>
                    <!--end::Form group-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Forgot-->
        </div>
        <!--end::Content body-->

        
    </div>
    <!--end::Content-->
</div>
<!--end::Login-->
	</div>
<!--end::Main-->


       
        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="<?php echo base_url(); ?>dist/assets/plugins/global/plugins.bundle.js?v=7.0.6"></script>
		    	   <script src="<?php echo base_url(); ?>dist/assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6"></script>
		    	   <script src="<?php echo base_url(); ?>dist/assets/js/scripts.bundle.js?v=7.0.6"></script>
				<!--end::Global Theme Bundle-->


                    <!--begin::Page Scripts(used by this page)-->
                            <!-- <script src="<?php echo base_url(); ?>dist/assets/js/pages/custom/login/login-general.js?v=7.0.6"></script> -->
                        <!--end::Page Scripts-->
            </body>
    <!--end::Body-->
</html>
