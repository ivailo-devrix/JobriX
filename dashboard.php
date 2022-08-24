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

$start_index = 0;
if ( ! empty( $_GET['page'] ) ) {
	$page_num    = mysqli_real_escape_string( open_db_conn(), $_GET['page'] );
	$start_index = jobs_start_index_for_page( $page_num );
}

$status    = "";
$jobs_list = get_jobs( $start_index, $status, $search );

?>
<section class="section-fullwidth section-jobs-dashboard">
    <div class="row">
        <div class="jobs-dashboard-header flex-container centered-vertically justified-horizontally">
            <div class="primary-container">
                <ul class="tabs-menu">
                    <li class="menu-item current-menu-item">
                        <a href="#">Jobs</a>
                    </li>
                    <li class="menu-item">
                        <a href="#">Categories</a>
                    </li>
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

		$s_parameter = '';
		if ( ! empty( $search ) ) {
			$s_parameter = '?search=' . $search;
		}
		$page_url    = 'dashboard.php' . $s_parameter;
		$active_jobs = active_jobs();
		pagination( $active_jobs, $page_url ); ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
