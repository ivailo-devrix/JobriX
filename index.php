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

$jobs_list = get_jobs( $start_index, $status, $search ); ?>
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
		<?php if ( mysqli_num_rows( $jobs_list ) > 0 ) {
			// output data of each row
			while ( $row = mysqli_fetch_assoc( $jobs_list ) ) { ?>
                <ul class="jobs-listing">
                    <li class="job-card">
                        <div class="job-primary">
                            <h2 class="job-title"><a
                                        href="<?php echo BASE_URL . "/job-view.php?id=" . $row['id_jobs'] ?>"><?php echo $row['title']; ?></a>
                            </h2>
                            <div class="job-meta">
	                            <?php if ( ! empty( $row['company_site'] ) ) { ?>
                                    <a class="meta-company" href="
                                       <?php echo 'http://' . $row['company_site'] ?>"><?php echo $row['company_name'] ?>
                                    </a>
	                            <?php } else {
		                            echo $row['company_name'];
	                            } ?>
                                <span class="meta-date">
                                        <?php echo date_difference( $row['publication_date'] ); ?>
                                    </span>
                            </div>
                            <div class="job-details">
                            <span class="job-location">
                                    <?php if ( ! empty( $row['jobs_location'] ) ) {
	                                    echo "Job location: " . $row['jobs_location'];
                                    } else {
	                                    echo "No location specified";
                                    } ?>
                                </span>
                                <span class="job-type">Contract staff:</span>
                                <span class="job-price"><?php echo $row['salary']; ?> лв.</span>
                            </div>
                        </div>


                        <div class="job-logo">
                            <div class="job-logo-box">
								<?php $img_file_logo = "." . IMAGE_PATH . $row['id_user'] . ".jpg";
								if ( file_exists( $img_file_logo ) ) {
									echo '<img src="' . BASE_URL . IMAGE_PATH . $row['id_user'] . ".jpg" . '" alt="">';
								} ?>
                            </div>
                        </div>


                    </li>
                </ul>
			<?php }
		} else {
			echo "0 results";
		}

		$s_parameter = '';
		if ( ! empty( $search ) ) {
			$s_parameter = '?search=' . $search;
		}
		$page_url    = 'index.php' . $s_parameter;
		$active_jobs = active_jobs();
		pagination( $active_jobs, $page_url ); ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
