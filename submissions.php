<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Submissions | Jobrix.tk";


//submissions.php?id=1

//Checks if a number is passed as a parameter in the _get request and if the given ID exists in the database
$id_job_submissions = "";
if ( ! isset( $_GET['id'] ) || ! is_numeric( $_GET['id'] ) ) {
	//header( 'Location: ' . BASE_URL );
}

$id_job_submissions = mysqli_real_escape_string( open_db_conn(), $_GET['id'] );
//$sql     = "SELECT submissions.*, user.* FROM submissions JOIN user ON submissions.id_user = user.id_user WHERE id_job = '$id_job_submissions'";
$sql = "SELECT submissions.*, jobs.* FROM submissions JOIN jobs ON submissions.id_job = jobs.id_jobs WHERE id_job = '$id_job_submissions'";
//$sql     = "SELECT jobs.*, user.* FROM jobs JOIN user ON user.id_user = jobs.id_user WHERE id_jobs = '$job_id'";
$result = db_sql_run( $sql );
$job    = db_sql_run( $sql );

//redirect to the home page if there is no job matching such id in the database
if ( mysqli_num_rows( $result ) < 1 ) {
	//header( 'Location: ' . BASE_URL );
}
$job = mysqli_fetch_assoc( $job );

$number_users = mysqli_num_rows( $result );

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' ); ?>
<section class="section-fullwidth">
    <div class="row">

		<?php if ( mysqli_num_rows( $result ) > 0 ) { ?>
            <div class="section-heading">
                <h2 class="heading-title"><?php echo $job['title'] . ' - Submissions - ' . $number_users . ' Applicants' ?> </h2>
            </div>
		<?php } ?>

        <ul class="jobs-listing">

			<?php if ( mysqli_num_rows( $result ) > 0 ) {
				// output data of each row
				while ( $row = mysqli_fetch_assoc( $result ) ) { ?>

                    <li class="job-card">
                        <div class="job-primary">
                            <h2 class="job-title"><?php echo $row['first_name'] . ' ' . $row['last_name'] ?></h2>
                        </div>
                        <div class="job-secondary centered-content">
                            <div class="job-actions">
                                <a href="<?php echo BASE_URL . '/view-submission.php?id_submissions=' . $row['id_submissions'] ?>"
                                   class="button button-inline">View</a>
                            </div>
                        </div>
                    </li>
				<?php }
			} else { ?>
                <div class="row">
                    <div class="flex-container centered-vertically centered-horizontally">
                        <div class="form-box box-shadow">
                            <div class="section-heading">
                                <h2 class="heading-title" style="color: red">There are no applications for this job
                                    posting!</h2>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
			<?php } ?>
        </ul>
		<?php pagination( $number_users, JOBS_PER_PAGE ); ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
