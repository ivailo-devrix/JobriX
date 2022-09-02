<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Dashboard | Jobrix.tk";
$page_name  = 'dashboard';

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' );

$search = '';
if ( isset( $_GET['search'] ) ) {
	$search = mysqli_real_escape_string( open_db_conn(), $_GET['search'] );
	$search = htmlspecialchars( $search );
}

//calculate start page listing index
if ( empty( $_GET['page'] ) ) {
	$start_index = 0;
} else {
	if ( $_GET['page'] == '1' ) {
		$start_index = 0;
	} else {
		$start_index = ( intval( $_GET['page'] ) - 1 ) * JOBS_PER_PAGE;
	}
}

$id_user = $_SESSION['id_user'];
$status  = "";
if ( ! empty( $_SESSION['is_admin'] ) ) {
	$id_user = '';
}
$jobs_list = get_jobs( $start_index, $status, $search, $id_user );

?>
<section class="section-fullwidth section-jobs-dashboard">
    <div class="row">
        <div class="jobs-dashboard-header flex-container centered-vertically justified-horizontally">
            <div class="primary-container">
                <ul class="tabs-menu">
                    <li class="menu-item current-menu-item">
                        <a href="<?php echo BASE_URL . '/dashboard.php'; ?>">Jobs</a>
                    </li>
					<?php if ( ! empty( $_SESSION['is_admin'] ) ): ?>
                        <li class="menu-item">
                            <a href="<?php echo BASE_URL . '/category-dashboard.php'; ?>">Categories</a>
                        </li>
					<?php endif; ?>
					<?php if ( empty( $_SESSION['is_admin'] ) ): ?>
                        <li class="menu-item">
                            <a href="<?php echo BASE_URL.'/actions-job.php'; ?>">Create New Job</a>
                        </li>
					<?php endif; ?>
                </ul>
            </div>
            <div class="secondary-container">
                <div class="flex-container centered-vertically">
                    <div class="search-form-wrapper">
                        <div class="search-form-field">
                            <input class="search-form-input" type="text" value="" placeholder="Search…"
                                   name="search">
                        </div>
                    </div>
                    <div class="filter-wrapper">
                        <div class="filter-field-wrapper">
                            <select>
                                <option value="1">Date</option>
                                <option value="2">Date</option>
                                <option value="3">Date</option>
                                <option value="4">Type</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/jobs-listing.php' );


		$number_article   = count_jobs( $status, $search, $id_user );
		$article_per_page = JOBS_PER_PAGE;
		pagination( $number_article, $article_per_page ); ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
