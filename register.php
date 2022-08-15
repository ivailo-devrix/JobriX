<?php require_once(dirname(__FILE__) . '/includes/theme-compat/header.php') ?>
    <section class="section-fullwidth">
        <div class="row">
            <div class="flex-container centered-vertically centered-horizontally">
                <div class="form-box box-shadow">
                    <div class="section-heading">
                        <h2 class="heading-title">Register</h2>
                    </div>
                    <form action="/form.php" id="register" method="post" enctype="multipart/form-data">
                        <div class="flex-container justified-horizontally">
                            <div class="primary-container">
                                <h4 class="form-title">About me</h4>
                                <input type="hidden" name="form_name" value="register"/>
                                <div class="form-field-wrapper">
                                    <input type="text" name="first_name" placeholder="First Name*"
                                           <?php if (!empty($_SESSION['first_name'])) {
                                               echo 'value="' . $_SESSION['first_name'] . '" style="color: #3c71fe;" ';
                                           } ?>required>
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="text" name="last_name"
                                           placeholder="Last Name*" <?php if (!empty($_SESSION['last_name'])) {
                                        echo 'value="' . $_SESSION['last_name'] . '" style="color: #3c71fe;" ';
                                    } ?> required>
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="email" name="email" placeholder="Email*" <?php if (!empty($_SESSION['email'])) {
                                        echo 'value="' . $_SESSION['email'] . '" style="color: #3c71fe;" ';
                                    } ?> required>
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="password" name="password" placeholder="Password*" required>
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="password" name="r_password" placeholder="Repeat Password*" required>
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="text" name="phone" placeholder="Phone Number" <?php if (!empty($_SESSION['phone'])) {
                                        echo 'value="' . $_SESSION['phone'] . '" style="color: #3c71fe;" ';
                                    } ?>
                                    >
                                </div>
                            </div>
                            <div class="secondary-container">
                                <h4 class="form-title">My Company</h4>
                                <div class="form-field-wrapper">
                                    <input type="text" name="company_name" placeholder="Company Name" <input type="text" name="phone" placeholder="Phone Number" <?php if (!empty($_SESSION['company_name'])) {
                                        echo 'value="' . $_SESSION['company_name'] . '" style="color: #3c71fe;" ';
                                    } ?>
                                    >
                                </div>
                                <div class="form-field-wrapper">
                                    <input type="text" name="company_site" placeholder="Company Site" <?php if (!empty($_SESSION['company_site'])) {
                                        echo 'value="' . $_SESSION['company_site'] . '" style="color: #3c71fe;" ';
                                    } ?>
                                    >
                                </div>
                                <div class="form-field-wrapper">
                                    <textarea name="company_description" placeholder="Description" <?php if (!empty($_SESSION['description'])) {
                                        echo 'value="' . $_SESSION['description'] . '" style="color: #3c71fe;" ';
                                    } ?>></textarea>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($_SESSION['errors'])) {
                            foreach ($_SESSION['errors'] as $error) {
                                echo "<p style=\"color: red;\"> $error </p>";
                            }
                        }
                        ?>
                        <button class="button">
                            Register
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php');
?>