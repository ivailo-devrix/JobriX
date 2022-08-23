<?php
require_once (dirname(__FILE__).'/includes/required-includes.php'); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

//params for include template
$meta_title = "Home Page | JobriX.tk";

//header template include
require_once (dirname(__FILE__).'/includes/theme-compat/header.php');


$sql = "SELECT COUNT(status)
FROM jobs
WHERE status = 'active'; ";

$result = db_sql_run($sql);
$result = mysqli_fetch_assoc($result);
$active_jobs = $result['COUNT(status)'];

$start_index = 0;


function jobs_start_index_for_page($page)
{
    return ($page * JOBS_PER_PAGE) - JOBS_PER_PAGE;
}

if (!empty($_GET['page'])) {
    $start_index = jobs_start_index_for_page($_GET['page']);
}


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
                    <div class="search-form-field">
                        <label>
                            <input class="search-form-input" type="text" value="" placeholder="Search…" name="search">
                        </label>
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

            <?php
            $sql = "SELECT jobs.*, user.company_name, user.company_site FROM jobs JOIN user ON user.id_user = jobs.id_user where status = 'active' LIMIT " . $start_index . "," . JOBS_PER_PAGE;
            $result = db_sql_run($sql);

            if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <ul class="jobs-listing">
                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a
                                    href="<?php echo BASE_URL . "/job-view.php?id=" . $row['id_jobs'] ?>"><?php echo $row['title']; ?></a>
                        </h2>
                        <div class="job-meta">
                            <a class="meta-company"
                               href="<?php echo BASE_URL . "/job-view.php?id=" . $row['id_jobs'] ?>"><?php echo $row['company_name']; ?></a>
                            <span class="meta-date"><?php echo date_difference( $row['publication_date'] ); ?></span>
                        </div>
                        <div class="job-details">
                        <span class="job-location"><?php
                            if (!empty($row['jobs_location'])) {
                                echo "Job location: " . $row['jobs_location'];
                            } else {
                                echo "No location specified";
                            }
                            ?></span>
                            <span class="job-type">Job Type: Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <?php
                            $img_file_logo = "." . IMAGE_PATH . $row['id_user'] . ".jpg";
                            if (file_exists($img_file_logo)) {
                                echo '<img src="' . BASE_URL . IMAGE_PATH . $row['id_user'] . ".jpg" . '" alt="">';
                            }
                            ?>
                        </div>
                    </div>
                </li>

                <?php
                }
                } else {
                    echo "0 results";
                }
                ?>

            </ul>
            <div class="jobs-pagination-wrapper">
                <div class="nav-links">
                    <?php
                    $las_page_num = round(($active_jobs / JOBS_PER_PAGE), 0); //7

                    for ($i = 1; $i <= $las_page_num; $i++) {
                        $active = '';

                        if (!empty($_GET['page'])) {
                            if ($_GET['page'] == $i) {
                                $active = ' current';
                            }
                        } elseif (1 == $i) {
                            $active = ' current';
                        }
                        echo '<a class="page-numbers' . $active . '" href="index.php?page=' . $i . '">' . $i . '</a>';
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php');
?>