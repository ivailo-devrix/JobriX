<?php
require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Actions Jobs | Jobrix.tk";

//check is longed in
if ( empty( $_SESSION['id_user'] ) ) {
	//redirect to home page
	header( 'Location: ' . BASE_URL );
	exit();
}

if ( empty( $_SESSION['is_company'] ) ) {
	//redirect to home page
	header( 'Location: ' . BASE_URL );
	exit();
}


//def variables used in template
$page_type = 'new';
$job_info  = array(
	'id_jobs'       => '',
	'id_user'       => '',
	'title'         => '',
	'description'   => '',
	'jobs_location' => '',
	'salary'        => '',
);


if ( ! empty( $_GET['id-job'] ) ) {
	$page_type = 'edit';
	$id_jobs   = $_GET['id-job'];

	$sql    = 'SELECT * FROM jobs where id_jobs = ' . $id_jobs;
	$result = db_sql_run( $sql );

	$job_sql = mysqli_fetch_assoc( $result );

	foreach ( $job_sql as $key => $value ) {
		if ( ! empty( $value ) && array_key_exists( $key, $job_info ) ) {
			$job_info[ $key ] = $value;
		}
	}

	//check jobs owner
	if ( empty( $_SESSION['is_admin'] ) ) {
		if ( $job_info['id_jobs'] != $_SESSION['id_user'] ) {
			//redirect to home page
			//header( 'Location: ' . BASE_URL );
		}
	}

} else {
	//kick admin if try add new jobs
	if ( ! empty( $_SESSION['id_admin'] ) ) {
		//redirect to home page
		header( 'Location: ' . BASE_URL );
	}
}

//POST Action
if ( ! empty( $_POST ) ) {
	$job_post_data = array(
		'id_jobs'       => '',
		'id_user'       => '',
		'title'         => '',
		'description'   => '',
		'jobs_location' => '',
		'salary'        => '',
		'form_name'     => '',
	);

	//check is longed in
	if ( empty( $_SESSION['id_user'] ) ) {
		//redirect to home page
		header( 'Location: ' . BASE_URL );
		exit();
	}

	foreach ( $_POST as $key => $value ) {
		if ( ! empty( $value ) && array_key_exists( $key, $job_post_data ) ) {
			$job_post_data[ $key ] = $value;
		}
	}
	echo "job post to DB:";

	//if minimum data for new job exist
	if ( ! empty( $job_post_data['form_name'] ) && ! empty( $job_post_data['title'] ) && ! empty( $job_post_data['description'] ) ) {
		if ( $job_post_data['form_name'] == 'edit-job' ) {
			if ( empty( $job_post_data['id_jobs'] ) ) {
				//redirect to home page
				header( 'Location: ' . BASE_URL );
				exit();
			}

			//get jobs owner
			$sql     = 'SELECT * FROM jobs where id_jobs = ' . $job_post_data['id_jobs'];
			$result  = db_sql_run( $sql );
			$job_sql = mysqli_fetch_assoc( $result );

			//check jobs owner
			if ( ! $_SESSION['is_admin'] ) {
				if ( $job_info != $_SESSION['id_user'] ) {
					//redirect to home page
					header( 'Location: ' . BASE_URL );
				}
			}

			$sql = "UPDATE `jobs` 
                    SET `title` = '" . $job_post_data['title'] . "', `description` = '" . $job_post_data['description'] . "',
                        `jobs_location` = '" . $job_post_data['jobs_location'] . "', `salary` = '" . $job_post_data['salary'] . "' 
	                WHERE `jobs`.`id_jobs` =" . $job_post_data['id_jobs'];

			echo "point2" . PHP_EOL;
		} elseif ( $job_post_data['form_name'] == 'new-job' ) {
			$id_user          = $_SESSION['id_user'];
			$publication_date = date( 'Y-m-d H:i:s' );
			$sql              = "INSERT INTO `jobs` (id_user, title, description, jobs_location, salary, status, publication_date) 
                    VALUES ('$id_user', '" . $job_post_data['title'] . "','" . $job_post_data['description'] . "', '" . $job_post_data['jobs_location'] . "','" . $job_post_data['salary'] . "','new','" . $publication_date . "')";
		}

		db_sql_run( $sql );

		header( 'Location: ' . '/dashboard.php' );

		//UPDATE `jobs` SET `title` = 'Работник - сглобяване на детайли ', `description` = 'Наш клиен', `jobs_location` = 'Varna ', `salary` = '1300' WHERE `jobs`.`id_jobs` =[...]
	}
}

//header template include
require_once(dirname(__FILE__) . '/includes/theme-compat/header.php');

?>
    <section class="section-fullwidth">
        <div class="row">
            <div class="flex-container centered-vertically centered-horizontally">
                <div class="form-box box-shadow">
                    <div class="section-heading">
                        <h2 class="heading-title"><?php echo ($page_type=='new') ? 'New job' : 'Edit Job'; ?></h2>
                    </div>
                    <form method="post">
                        <div class="flex-container flex-wrap">
                            <input type="hidden" name="id_jobs" value="<?php echo $job_info['id_jobs']; ?>"/>
                            <input type="hidden" name="form_name"
                                   value="<?php echo ( $page_type == 'new' ) ? 'new-job' : 'edit-job'; ?>"/>
                            <div class="form-field-wrapper width-large">
                                <input type="text" name="title"
                                       required placeholder="Job title*" value="<?php echo $job_info['title']; ?>">
                            </div>
                            <div class="form-field-wrapper width-large">
                                <input type="text" name="jobs_location" placeholder="Location"
                                       value="<?php echo $job_info['jobs_location']; ?>">
                            </div>
                            <div class="form-field-wrapper width-large">
                                <input type="text" name="salary" placeholder="Salary"
                                       value="<?php echo $job_info['salary']; ?>">
                            </div>
                            <div class="form-field-wrapper width-large">
                                <textarea name="description" required
                                          placeholder="Description*"><?php echo $job_info['description']; ?></textarea>
                            </div>
                        </div>
                        <button type="submit" class="button">
							<?php echo ( $page_type == 'new' ) ? 'Create' : 'Save'; ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>