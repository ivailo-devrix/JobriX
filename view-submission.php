<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "View Submissions | Jobrix.tk";


//Checks if a number is passed as a parameter in the _get request and if the given ID exists in the database
$id_submissions = "";
if ( ! isset( $_GET['id_submissions'] ) || ! is_numeric( $_GET['id_submissions'] ) ) {
	//header( 'Location: ' . BASE_URL );
}

$id_submissions = mysqli_real_escape_string( open_db_conn(), $_GET['id_submissions'] );
$sql            = "SELECT submissions.*, jobs.title FROM submissions JOIN jobs ON submissions.id_job = jobs.id_jobs WHERE id_submissions = '$id_submissions'";
$result         = db_sql_run( $sql );

//redirect to the home page if there is no job matching such id in the database
if ( mysqli_num_rows( $result ) < 1 ) {
	//header( 'Location: ' . BASE_URL );
}

$row = mysqli_fetch_assoc( $result );

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' ); ?>
<section class="section-fullwidth">
    <div class="row">
        <div class="flex-container centered-vertically centered-horizontally">
            <div class="form-box box-shadow">
                <div class="section-heading">
                    <h2 class="heading-title"><?php echo $row['title'] . ' - ' . "<br>" . $row['first_name'] . ' ' . $row['last_name']; ?></h2>
                </div>
                <form>
                    <div class="flex-container justified-horizontally flex-wrap">
                        <div class="form-field-wrapper width-medium">
                            <input type="text" placeholder="Email" value="<?php echo $row['email'] ?>" readonly/>
                        </div>
                        <div class="form-field-wrapper width-medium">
                            <input type="text" placeholder="Phone Number" value="<?php echo $row['phone'] ?>" readonly/>
                        </div>
                        <div class="form-field-wrapper width-large">
                            <textarea placeholder="Custom Message"
                                      readonly><?php echo $row['custom_message'] ?></textarea>
                        </div>
                    </div>
                    <a href="<?php echo $row['doc_upload'] ?>">Download CV</a>
                </form>
            </div>
        </div>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
