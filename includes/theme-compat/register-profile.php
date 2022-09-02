<section class="section-fullwidth">
    <div class="row">
        <div class="flex-container centered-vertically centered-horizontally">
            <div class="form-box box-shadow">
                <div class="section-heading">
					<?php if ( ! empty( $page_name ) && $page_name == 'profile' ) { ?> <h2 class="heading-title">My
                        Profile</h2> <?php } ?>
					<?php if ( ! empty( $page_name ) && $page_name == 'register' ) { ?> <h2 class="heading-title">
                        Register</h2> <?php } ?>
                </div>
                <form action="<?php if ( ! empty( $page_name ) && $page_name == 'profile' ) {
					echo '/forms-action.php';
				} else {
					echo '/forms-action.php';
				} ?>" id="register" method="post" enctype="multipart/form-data">
                    <div class="flex-container justified-horizontally">
                        <div class="primary-container">
                            <h4 class="form-title">About me</h4>
                            <input type="hidden" name="form_name"
                                   value="<?php if ( ! empty( $page_name ) && $page_name == 'profile' ) {
								       echo 'edit_profile';
							       } else {
								       echo 'register';
							       } ?>"/>
                            <div class="form-field-wrapper">
                                <input type="text" name="first_name" placeholder="First Name*"
									<?php if ( ! empty( $_SESSION['input_data']['first_name'] ) ) {
										echo 'value="' . $_SESSION['input_data']['first_name'] . '" class="correct" ';
									} ?> required>
                            </div>
                            <div class="form-field-wrapper">
                                <input type="text" name="last_name"
                                       placeholder="Last Name*" <?php if ( ! empty( $_SESSION['input_data']['last_name'] ) ) {
									echo 'value="' . $_SESSION['input_data']['last_name'] . '" class="correct" ';
								} ?> required>
                            </div>
                            <div class="form-field-wrapper">
                                <input type="email" name="email" placeholder="Email*"
									<?php if ( ! empty( $_SESSION['input_data']['email'] ) ) {
										echo 'value="' . $_SESSION['input_data']['email'] . '" class="correct" ';
									} ?> required>
                            </div>
							<?php if ( ! empty( $page_name ) && $page_name == 'register' ) { ?>
                                <div class="form-field-wrapper">
                                    <input type="password" name="password" placeholder="Password*" required>
                                </div>
							<?php }
							if ( ! empty( $page_name ) && $page_name == 'register' ) { ?>
                                <div class="form-field-wrapper">
                                    <input type="password" name="r_password" placeholder="Repeat Password*" required>
                                </div>
							<?php }
							if ( ! empty( $page_name ) && $page_name == 'profile' ) { ?>
                                <div class="form-field-wrapper">
                                    <input type="password" name="password" placeholder="Password">
                                </div>
							<?php }
							if ( ! empty( $page_name ) && $page_name == 'profile' ) { ?>
                                <div class="form-field-wrapper">
                                    <input type="password" name="r_password" placeholder="Repeat Password">
                                </div>
							<?php } ?>
                            <div class="form-field-wrapper">
                                <input type="text" name="phone" placeholder="Phone Number"
									<?php if ( ! empty( $_SESSION['input_data']['input_phone'] ) ) {
										echo 'value="' . $_SESSION['input_data']['input_phone'] . '" class="correct" ';
									}
									if ( ! empty( $_SESSION['input_data']['phone'] ) ) {
										echo 'value="' . $_SESSION['input_data']['phone'] . '" class="correct" ';
									} ?>
                                >
                            </div>
                        </div>
                        <div class="secondary-container">
                            <h4 class="form-title">My Company</h4>
                            <div class="form-field-wrapper">
                                <input type="text" name="company_name" placeholder="Company Name" <input type="text"
                                                                                                         name="phone"
                                                                                                         placeholder="Phone Number"
									<?php if ( ! empty( $_SESSION['input_data']['company_name'] ) ) {
										echo 'value="' . $_SESSION['input_data']['company_name'] . '" class="correct" ';
									} ?>
                                >
                            </div>
                            <div class="form-field-wrapper">
                                <input type="text" name="company_site"
                                       placeholder="Company Site" <?php if ( ! empty( $_SESSION['input_data']['company_site'] ) ) {
									echo 'value="' . $_SESSION['input_data']['company_site'] . '" class="correct" ';
								} ?>
                                >
                            </div>
                            <div class="form-field-wrapper">
                                    <textarea name="company_description" placeholder="Description"
                                        <?php if ( ! empty( $_SESSION['input_data']['company_description'] ) ) {
	                                        echo '" class="correct" ';
                                        } ?>
                                    ><?php if ( ! empty( $_SESSION['input_data']['company_description'] ) ) {
		                                    echo $_SESSION['input_data']['company_description'];
	                                    } ?></textarea>
                            </div>
							<?php if ( ! empty( $_SESSION['id_user'] ) ) { ?>
                                <div class="job-logo">
                                    <div class="job-logo-box">
										<?php $img_file_logo = "./img/company/" . $_SESSION['id_user'] . ".jpg";
										if ( file_exists( $img_file_logo ) ) {
											echo '<img src="' . BASE_URL . "/img/company/" . $_SESSION['id_user'] . ".jpg" . '" alt="company logo">';
										} else {
											echo '<img src="' . BASE_URL . "/img/company/" . "404.gif" . '" alt="company logo">';
										} ?>
                                    </div>
                                </div>
							<?php } ?>
							<?php
							if ( ! empty( $_SESSION['id_user'] ) ) {
								$img_file_logo = "./img/company/" . $_SESSION['id_user'] . ".jpg";

								if ( file_exists( $img_file_logo ) ) {
									echo '  Change company logo:';
								} else {
									echo '  Upload company logo:';
								}
							} else {
								echo '  Upload company logo:';
							} ?>
                            <input type="file" name="fileToUpload" id="fileToUpload">
                        </div>
                    </div>
					<?php if ( ! empty( $_SESSION['errors'] ) ) {
						foreach ( $_SESSION['errors'] as $error ) {
							echo '<p class="error">' . $error . '</p>';
						}
					} ?>
                    <button class="button" type="submit" name="submit">
						<?php if ( ! empty( $page_name ) && $page_name == 'profile' ) {
							echo 'Save';
						} else {
							echo 'Register';
						} ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>