<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Apply Submissions | Jobrix.tk";

//Checks if a number is passed as a parameter in the _get request and if the given ID exists in the database
$job_id = "";
if (!isset( $_GET['job-id'] ) || ! is_numeric( $_GET['job-id'] ) ) {
	header( 'Location: ' . BASE_URL );
}

$job_id = mysqli_real_escape_string( open_db_conn(), $_GET['job-id'] );
$sql    = "SELECT jobs.*, user.* FROM jobs JOIN user ON user.id_user = jobs.id_user WHERE id_jobs = '$job_id'";
$result = db_sql_run( $sql );
//redirect to the home page if there is no job matching such id in the database
if ( mysqli_num_rows( $result ) < 1 ) {
	//header( 'Location: ' . BASE_URL );
}

$row = mysqli_fetch_assoc( $result );

$job = array(
	'title'               => '',
	'company_name'        => '',
	'company_description' => '',
	'company_site'        => '',
	'publication_date'    => '',
	'jobs_location'       => '',
	'salary'              => '',
	'description'         => '',
	'id_user'             => '',
	'id_jobs'             => '',
);

foreach ($row as $key => $value )
{
	if ( ! empty( $value ) && array_key_exists( $key, $job ) ) {
		$job[ $key ] = $value;
	}
}


//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' ); ?>
<section class="section-fullwidth">
    <div class="row">
        <div class="flex-container centered-vertically centered-horizontally">
            <div class="form-box box-shadow">
                <div class="section-heading">
                    <h2 class="heading-title">Submit application to
						<?php echo $job['company_name'] ?></h2>
                </div>
                <form action="/forms-action.php" id="apply-submission" method="post" enctype="multipart/form-data">
                    <div class="flex-container justified-horizontally flex-wrap">
                        <div class="form-field-wrapper width-medium">
                            <input type="hidden" name="form_name" value="apply-submission">
                            <input type="hidden" name="job-id" value="<?php echo $job_id; ?>">
                            <input type="text" name="first_name" placeholder="First Name*" required>
                        </div>
                        <div class="form-field-wrapper width-medium">
                            <input type="text" name="last_name" placeholder="Last Name*" required>
                        </div>
                        <div class="form-field-wrapper width-medium">
                            <input type="email" name="email" placeholder="Email*" required>
                        </div>
                        <div class="form-field-wrapper width-medium">
                            <input type="text" name="phone" placeholder="Phone Number"/>
                        </div>
                        <div class="form-field-wrapper width-large">
                            <textarea name="message" placeholder="Custom Message*" required></textarea>
                        </div>
                        <div class="form-field-wrapper width-large">
                            <input type="file" name="fileToUpload">
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
