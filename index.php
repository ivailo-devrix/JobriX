<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection


//params for include template
$meta_title = "Home Page | JobriX.tk";
$page_name  = 'home';

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

$status = "active";

// get SQL result
$jobs_list = get_jobs( $start_index, $status, $search );

// get active result  - number match for pagination
$active_jobs = count_jobs( $status, $search );

?>
<section class="section-fullwidth section-jobs-preview">
    <div class="row">
        <ul class="tags-list">
            <li class="list-item">
                <a href="#" class="list-item-link">IT</a>
            </li>
            <li class="list-item">
                <a href="#" class="list-item-link">Manufactoring</a>
            </li>
            <li class="list-item">
                <a href="#" class="list-item-link">Commerce</a>
            </li>
            <li class="list-item">
                <a href="#" class="list-item-link">Architecture</a>
            </li>
            <li class="list-item">
                <a href="#" class="list-item-link">Marketing</a>
            </li>
        </ul>
        <div class="flex-container centered-vertically">
            <div class="search-form-wrapper">
                <form class="example" method="GET">
                    <div class="search-form-field">
                        <input class="search-form-input" type="text"
                               value="<?php if ( ! empty( $search ) ) {
							       echo $search;
						       } ?>" placeholder="Search…" name="search">
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
                </form>
            </div>
        </div>
		<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/jobs-listing.php' );

		pagination( $active_jobs, JOBS_PER_PAGE ); ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
