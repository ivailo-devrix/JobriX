<?php
require_once (dirname(__FILE__).'/includes/required-includes.php'); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Actions Jobs | Jobrix.tk";

//header template include
require_once (dirname(__FILE__).'/includes/theme-compat/header.php');
?>
			<section class="section-fullwidth">
				<div class="row">
					<div class="flex-container centered-vertically centered-horizontally">
						<div class="form-box box-shadow">
							<div class="section-heading">
								<h2 class="heading-title">New job</h2>
							</div>
							<form>
								<div class="flex-container flex-wrap">
									<div class="form-field-wrapper width-large">
										<input type="text" placeholder="Job title*"/>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" placeholder="Location"/>
									</div>
									<div class="form-field-wrapper width-large">
										<input type="text" placeholder="Salary"/>
									</div>
									<div class="form-field-wrapper width-large">
										<textarea placeholder="Description*"></textarea>
									</div>
								</div>
								<button type="submit" class="button">
									Create
								</button>
							</form>
						</div>
					</div>
				</div>
			</section>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php');
?>