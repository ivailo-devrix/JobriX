<?php require_once (dirname(__FILE__).'/includes/theme-compat/header.php') ?>
			<section class="section-fullwidth section-jobs-dashboard">
				<div class="row">						
					<div class="jobs-dashboard-header">
						<div class="primary-container">							
							<ul class="tabs-menu">
								<li class="menu-item">
									<a href="#">Jobs</a>					
								</li>
								<li class="menu-item current-menu-item">
									<a href="#">Categories</a>
								</li>
							</ul>
						</div>
						<div class="secondary-container">
							<div class="form-box category-form">
								<form>
									<div class="flex-container justified-vertically">									
										<div class="form-field-wrapper">
											<input type="text" placeholder="Enter Category Name..."/>
										</div>
										<button class="button">
											Add New
										</button>
									</div>	
								</form>
							</div>
						</div>
					</div>
					<ul class="jobs-listing">
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title">Category Name</h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
								</div>
							</div>
						</li>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title">Category Name</h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
								</div>
							</div>
						</li>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title">Category Name</h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
								</div>
							</div>
						</li>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title">Category Name</h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
								</div>
							</div>
						</li>
						<li class="job-card">
							<div class="job-primary">
								<h2 class="job-title">Category Name</h2>
							</div>
							<div class="job-secondary centered-content">
								<div class="job-actions">
									<a href="#" class="button button-inline">Delete</a>
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
<?php require_once (dirname(__FILE__).'/includes/theme-compat/footer.php') ?>