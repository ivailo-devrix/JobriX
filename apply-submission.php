<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Apply Submissions | Jobrix.tk";

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' ); ?>
    <section class="section-fullwidth">
        <div class="row">
            <div class="flex-container centered-vertically centered-horizontally">
                <div class="form-box box-shadow">
                    <div class="section-heading">
                        <h2 class="heading-title">Submit application to
                            Company Name</h2>
                    </div>
                    <form>
                        <div class="flex-container justified-horizontally flex-wrap">
                            <div class="form-field-wrapper width-medium">
                                <input type="text" placeholder="First Name*"/>
                            </div>
                            <div class="form-field-wrapper width-medium">
                                <input type="text" placeholder="Last Name*"/>
                            </div>
                            <div class="form-field-wrapper width-medium">
                                <input type="text" placeholder="Email*"/>
                            </div>
                            <div class="form-field-wrapper width-medium">
                                <input type="text" placeholder="Phone Number"/>
                            </div>
                            <div class="form-field-wrapper width-large">
                                <textarea placeholder="Custom Message*"></textarea>
                            </div>
                            <div class="form-field-wrapper width-large">
                                <input type="file"/>
                            </div>
                        </div>
                        <button class="button">
                            Submit
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
