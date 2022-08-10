<?php
require_once(dirname(__FILE__) . '/includes/theme-compat/header.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/db-connect.php');
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
                    <label>
                        <select>
                            <option value="1">Date</option>
                            <option value="2">Date</option>
                            <option value="3">Date</option>
                            <option value="4">Type</option>
                        </select>
                    </label>
                </div>
            </div>
        </div>


        <?php

        $sql = "SELECT jobs.*, user.company_name, user.company_site FROM jobs JOIN user ON user.id_user = jobs.id_user where status = 'active'";
        $result = db_sql_run($sql);

        if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <ul class="jobs-listing">
            <li class="job-card">
                <div class="job-primary">
                    <h2 class="job-title"><a href="<?php echo $HTTP_DOMAIN . "/job-view.php?id=" . $row['id_jobs'] ?>"><?php echo $row['title']; ?></a></h2>
                    <div class="job-meta">
                        <a class="meta-company"
                           href="<?php echo $HTTP_DOMAIN . "/job-view.php?id=" . $row['id_jobs'] ?>"><?php echo $row['company_name']; ?></a>
                        <span class="meta-date"><?php if (date_difference($row['publication_date']) < 31) {
                                echo "Posted " . date_difference($row['publication_date']) . " days ago";
                            } else {
                                echo "Posted over 1 month ago";
                            } ?></span>
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
                        <img src="<?php echo $HTTP_DOMAIN . "/img/company/" . $row['id_user'] . ".jpg"; ?>" alt="">
                    </div>
                </div>
            </li>

            <?php

            }
            } else {
                echo "0 results";
            }
            ?>
            <ul class="jobs-listing">


                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a href="#">Front End Developer</a></h2>
                        <div class="job-meta">
                            <a class="meta-company" href="#">Company Awesome Ltd.</a>
                            <span class="meta-date">Posted 14 days ago</span>
                        </div>
                        <div class="job-details">
                            <span class="job-location">The Hague (The Netherlands)</span>
                            <span class="job-type">Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <img src="https://i.imgur.com/ZbILm3F.png" alt="">
                        </div>
                    </div>
                </li>


                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a href="#">Front End Developer</a></h2>
                        <div class="job-meta">
                            <a class="meta-company" href="#">Company Awesome Ltd.</a>
                            <span class="meta-date">Posted 14 days ago</span>
                        </div>
                        <div class="job-details">
                            <span class="job-location">The Hague (The Netherlands)</span>
                            <span class="job-type">Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <img src="https://i.imgur.com/ZbILm3F.png" alt="">
                        </div>
                    </div>
                </li>


                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a href="#">Front End Developer</a></h2>
                        <div class="job-meta">
                            <a class="meta-company" href="#">Company Awesome Ltd.</a>
                            <span class="meta-date">Posted 14 days ago</span>
                        </div>
                        <div class="job-details">
                            <span class="job-location">The Hague (The Netherlands)</span>
                            <span class="job-type">Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <img src="https://i.imgur.com/ZbILm3F.png" alt="">
                        </div>
                    </div>
                </li>
                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a href="#">Front End Developer</a></h2>
                        <div class="job-meta">
                            <a class="meta-company" href="#">Company Awesome Ltd.</a>
                            <span class="meta-date">Posted 14 days ago</span>
                        </div>
                        <div class="job-details">
                            <span class="job-location">The Hague (The Netherlands)</span>
                            <span class="job-type">Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <img src="https://i.imgur.com/ZbILm3F.png" alt="">
                        </div>
                    </div>
                </li>
                <li class="job-card">
                    <div class="job-primary">
                        <h2 class="job-title"><a href="#">Front End Developer</a></h2>
                        <div class="job-meta">
                            <a class="meta-company" href="#">Company Awesome Ltd.</a>
                            <span class="meta-date">Posted 14 days ago</span>
                        </div>
                        <div class="job-details">
                            <span class="job-location">The Hague (The Netherlands)</span>
                            <span class="job-type">Contract staff</span>
                        </div>
                    </div>
                    <div class="job-logo">
                        <div class="job-logo-box">
                            <img src="https://i.imgur.com/ZbILm3F.png" alt="">
                        </div>
                    </div>
                </li>
            </ul>
            <div class="jobs-pagination-wrapper">
                <div class="nav-links">
                    <a class="page-numbers current">1</a>
                    <a class="page-numbers">2</a>
                    <a class="page-numbers">3</a>
                    <a class="page-numbers">4</a>
                    <a class="page-numbers">5</a>
                </div>
            </div>
    </div>
</section>
<?php require_once(dirname(__FILE__) . '/includes/theme-compat/footer.php') ?>
