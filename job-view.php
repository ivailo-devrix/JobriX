<?php
require_once(dirname(__FILE__) . '/includes/required-includes.php'); //Necessary file containing: The necessary custom functions, Config file constants, DB connection

$jobs_id = $_GET['id'];
$sql = "SELECT jobs.*, user.company_name, user.company_site FROM jobs JOIN user ON user.id_user = jobs.id_user WHERE id_jobs = '$jobs_id'";
$result = db_sql_run($sql);

if (mysqli_num_rows($result) < 1) {
    header('Location: ' . BASE_URL);
}
$row = mysqli_fetch_assoc($result);


//params for include template
$meta_title = $row['title'] . " | Jobrix.tk";

//header template include
require_once(dirname(__FILE__) . '/includes/theme-compat/header.php');

//Checks if a number is passed as a parameter in the _get request and if the given ID exists in the database
$jobs_id = "";
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ' . BASE_URL);
} ?>
<section class="section-fullwidth">
    <div class="row">
        <div class="job-single">
            <div class="job-main">
                <div class="job-card">
                    <div class="job-primary">
                        <header class="job-header">
                            <h2 class="job-title"><?php echo $row['title'] ?></h2>
                            <div class="job-meta">
                                <a class="meta-company" href="#"><?php echo $row['company_name'] ?></a>
                                <span class="meta-date">
                                        <?php
                                        if (date_difference($row['publication_date']) < 31) {
                                            echo "Posted " . date_difference($row['publication_date']) . " days ago";
                                        } else {
                                            echo "Posted over 1 month ago";
                                        }
                                        ?>
                                    </span>
                            </div>
                            <div class="job-details">
                                    <span class="job-location">
                                        <?php
                                        if (!empty($row['jobs_location'])) {
                                            echo "Job location: " . $row['jobs_location'];
                                        } else {
                                            echo "No location specified";
                                        }
                                        ?>
                                    </span>
                                <span class="job-type">Contract staff:</span>
                                <span class="job-price"><?php echo $row['salary']; ?> лв.</span>
                            </div>
                        </header>
                        <div class="job-body">
                            <?php
                            echo $row['description'];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="job-secondary">
                <div class="job-logo">
                    <div class="job-logo-box">
                        <?php
                        $img_file_logo = "./img/company/" . $row['id_user'] . ".jpg";
                        if (file_exists($img_file_logo)) {
                            echo '<img src="' . BASE_URL . "/img/company/" . $row['id_user'] . ".jpg" . '" alt="">';
                        } else {
                            echo '<img src="' . BASE_URL . "/img/company/" . "404.gif" . '" alt="">';
                        }
                        ?>
                    </div>
                </div>
                <a href="#" class="button button-wide">Apply now</a>
                <?php
                if (!empty($row['company_site'])) { ?>
                    <a href="<?php echo "http://" . $row['company_site']; ?>"
                       target="_blank"><?php echo $row['company_site']; ?></a>
                <?php }
                ?>
            </aside>
        </div>
    </div>
</section>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/theme-compat/footer.php');
?>
