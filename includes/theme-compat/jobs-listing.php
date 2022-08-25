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
                        <span class="meta-date">Posted 14 days ago</span>
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
				<?php if ( $page_name == 'dashboard' ) { ?>
                    <div class="job-secondary">
						<?php if ( $row['status'] == 'new' ) { ?>
                            <div class="job-actions">
                                <a href="<?php echo BASE_URL . '/jobs-actions.php' . '?id=' . $row['id_jobs'] . '&action=approve'; ?>">Approve</a>
                                <a href="<?php echo BASE_URL . '/jobs-actions.php' . '?id=' . $row['id_jobs'] . '&action=reject'; ?>">Reject</a>
                            </div>
						<?php } ?>
                        <div class="job-edit">
                            <a href="<?php echo BASE_URL . '/submissions.php?id=' . $row['id_jobs']; ?>">
                                View Submissions</a>
                            <a href="<?php echo BASE_URL . '/actions-job.php?id=' . $row['id_jobs']; ?>">Edit</a>
                        </div>
                    </div>
				<?php }
				if ( $page_name == 'home' ) { ?>
                    <div class="job-logo">
                        <div class="job-logo-box">
							<?php $img_file_logo = "." . IMAGE_PATH . $row['id_user'] . ".jpg";
							if ( file_exists( $img_file_logo ) ) {
								echo '<img src="' . BASE_URL . IMAGE_PATH . $row['id_user'] . ".jpg" . '" alt="">';
							} ?>
                        </div>
                    </div>
				<?php } ?>

            </li>
        </ul>
	<?php }
} else {
	echo "0 results";
} ?>
