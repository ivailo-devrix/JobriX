<?php require_once( dirname( __FILE__ ) . '/includes/required-includes.php' ); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Category Dashboard | Jobrix.tk";


//check is longed in
if ( empty( $_SESSION['id_user'] ) ) {
	//redirect to home page
	header( 'Location: ' . BASE_URL );
}

if ( empty( $_SESSION['is_admin'] ) ) {
	//redirect to home page
	header( 'Location: ' . BASE_URL );
}


//calculate start page listing index
if ( empty( $_GET['page'] ) ) {
	$start_index = 0;
} else {
	if ( $_GET['page'] === '1' ) {
		$start_index = 0;
	} else {
		$start_index = ( intval( $_GET['page'] ) - 1 ) * CATS_PER_PAGE;
	}
}


$categories_list = get_categories_list( $start_index );


//store last input cat if exist
if ( ! empty( $_SESSION['input'] ) ) {
	$input = $_SESSION['input'];
} else {
	$input = '';
}

//header template include
require_once( dirname( __FILE__ ) . '/includes/theme-compat/header.php' ); ?>
<section class="section-fullwidth section-jobs-dashboard">
    <div class="row">
        <div class="jobs-dashboard-header">
            <div class="primary-container">
                <ul class="tabs-menu">
                    <li class="menu-item">
                        <a href="<?php echo BASE_URL . '/dashboard.php'; ?>">Jobs</a>
                    </li>
                    <li class="menu-item current-menu-item">
                        <a href="<?php echo BASE_URL . '/category-dashboard.php'; ?>">Categories</a>
                    </li>
                </ul>
            </div>
            <div class="secondary-container">
                <div class="form-box category-form">
                    <form action="/action-cat.php" method="get" id="form1">
						<?php if ( ! empty( $_SESSION['error'] ) ) {
							echo '<p class="error">' . $_SESSION['error'] . '</p>';
						} ?>
                        <div class="flex-container justified-vertically">

                            <div class="form-field-wrapper">
                                <input type="text" name="cat-name" placeholder="Enter Category Name..."
                                       value="<?PHP echo $input ?>">
                                <input type="hidden" name="action" value="new">

                            </div>

                            <button type="submit" form="form1" value="Submit" class="button">
                                Add New
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
        <ul class="jobs-listing">
			<?php if ( mysqli_num_rows( $categories_list ) > 0 ) {
				// output data of each row
				while ( $row = mysqli_fetch_assoc( $categories_list ) ) { ?>
                    <li class="job-card">
                        <div class="job-primary">
                            <h2 class="job-title"><?php echo $row['name']; ?></h2>
                        </div>
                        <div class="job-secondary centered-content">
                            <div class="job-actions">
                                <a href="<?php echo BASE_URL . '/action-cat.php' . '?id=' . $row['id_category'] . '&action=delete'; ?>"
                                   class="button button-inline">Delete</a>
                            </div>
                        </div>
                    </li>
				<?php }
			} ?>
        </ul>
		<?php
		//pagination display which should be rewritten as a function
		$s_parameter = '';
		if ( ! empty( $search ) ) {
			$s_parameter = '?search=' . $search;
		}
		$page_url         = 'category-dashboard.php' . $s_parameter;
		$num_article      = count_cat();
		$article_per_page = CATS_PER_PAGE;
		pagination($num_article, $article_per_page);
        ?>
    </div>
</section>
<?php require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php' ); ?>
