<?php

date_default_timezone_set( DEF_TIME_ZONE );


function date_difference( $date_1, $difference_format = '%a' ) {
	$datetime1 = date_create( $date_1 );
	$datetime2 = date_create();

	$interval = date_diff( $datetime2, $datetime1 );

	$interval = $interval->format( $difference_format );

	if ( $interval < 31 ) {
		return "Posted " . $interval . " days ago";
	} else {
		return "Posted over 1 month ago";
	}
}


/**
 * Extract and Check domain validation.
 *
 * @param string $domain_or_url Accepts url address or domain.
 *
 * @return bool|string With the valid domain if domain is valid and boolean 'FALSE' if the domain is not valid.
 */
function extract_valid_domaine( $domain_or_url ) {
	//extract domain from url
	$domain_or_url     = trim( $domain_or_url );
	$domain_or_url     = str_replace( array( 'http://', 'https://' ), '', $domain_or_url );
	$domain_or_url_arr = explode( '/', $domain_or_url );
	$domain            = trim( $domain_or_url_arr[0] );

	// check pattern
	$valid_pattern = ( preg_match( "/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/", $domain ) );

	// check DNS records
	$valid_dns = dns_get_record( $domain );

	if ( $valid_pattern && $valid_dns ) {
		return $domain;
	} else {
		return false;
	}
}


/**
 * Extract and Validate Phone Number: use Bulgarian format.
 *
 * @param string $phone Accepts Phone string in multiple type formats.
 *
 * @return string With the valid Phone if Phone is valid and boolean 'FALSE' if the Phone is not valid.
 */
function extract_valid_phone( $phone ) {
	//remove chars - / ( ) and space
	$phone = trim( $phone );
	$phone = str_replace( array( ' ', '(', ')', '-', '/', '\\' ), '', $phone );

	if ( preg_match( '/^(\+359|0)\s?8(\d{2}\s\d{3}\d{3}|[789]\d{7})$/', $phone ) ) {
		return str_replace( '+359', 0, $phone );
	} else {
		return false;
	}
}


function pagination( $number_of_items, $article_per_page ) {

	//prevent division by zero
	if ( $number_of_items == 0 || $article_per_page == 0 ) {
		return null;
	}

	//calc number of page
	$las_page_num = intval( ceil( ( intval( $number_of_items ) / intval( $article_per_page ) ) ) );


	//if all results fit on one page, stop the function
	if ( $las_page_num == 1 ) {
		return null;
	}

	//
	$page_url = strtok( $_SERVER["REQUEST_URI"], '?' );


	$page_ling_arr = array();

//	for ( $i = 1; $i <= $las_page_num; $i ++ ) {
//		$active = '';
//		if ( ! empty( $_GET['page'] ) ) {
//			if ( $_GET['page'] == $i ) {
//				$active = ' current';
//			}
//		} elseif ( 1 == $i ) {
//			$active = ' current';
//		}
//		if ( ! empty( $_GET ) && empty( $_GET['page'] ) ) {
//			$concatenate = '&';
//		} else {
//			$concatenate = '?';
//		}
//
//		$page_ling_arr[] = '<a class="page-numbers' . $active . '" href="' . $page_url . $concatenate . 'page=' . $i . '">' . $i . '</a>';
//	}
//
	for ( $i = 1; $i <= $las_page_num; $i ++ ) {
		$active_page = '';
		if ( ! empty( $_GET['page'] ) ) {
			if ( $_GET['page'] == $i ) {
				$active_page = ' current';
			}
		} elseif ( 1 == $i ) {
			$active_page = ' current';
		}


		$get_params = array();
		foreach ( $_GET as $key => $value ) {
			if ( $key != 'page' ) {
				$get_params[] = "$key=$value";
			}
		}


		if ( count( $get_params ) > 0 ) {
			$additional_params = "&" . implode( '&', $get_params );
		} else {
			$additional_params = '';
		}


		$page_ling_arr[] = '<a class="page-numbers' . $active_page . '" href="' . $page_url . '?page=' . $i . $additional_params . '">' . $i . '</a>';
	}


	?>



    <div class="jobs-pagination-wrapper">
    <div class="nav-links">
		<?php echo implode( ' ', $page_ling_arr ); ?>
    </div>
    </div><?php


}


function pagination_copy( $number_of_items, $page_url, $article_per_page ) {

	//calc number of page
	$las_page_num = ceil( ( $number_of_items / $article_per_page ) );

	$var = <<<EOD

<div class="jobs-pagination-wrapper">
	<div class="nav-links">
EOD;
	echo $var;

	for ( $i = 1; $i <= $las_page_num; $i ++ ) {
		$active = '';
		if ( ! empty( $_GET['page'] ) ) {
			if ( $_GET['page'] == $i ) {
				$active = ' current';
			}
		} elseif ( 1 == $i ) {
			$active = ' current';
		}
		if ( ! empty( $_GET ) && empty( $_GET['page'] ) ) {
			$concatenate = '&';
		} else {
			$concatenate = '?';
		}
		echo '<a class="page-numbers' . $active . '" href="' . $page_url . $concatenate . 'page=' . $i . '">' . $i . '</a>';
	}

	$var = <<<EOD

</div>
	</div>
EOD;
	echo $var;

}


function countt_jobs( $status = '' ) {
	if ( empty( $status ) ) {
		$sql = 'SELECT COUNT(status)
			FROM jobs;';
	} else {
		$sql = "SELECT COUNT(status)
			FROM jobs
			WHERE status = '" . $status . "';";
	}


	$result = db_sql_run( $sql );
	$result = mysqli_fetch_assoc( $result );

	return $result['COUNT(status)'];
}


function count_jobs( $status, $search = '', $id_user = '' ) {
	if ( ! empty( $search ) ) {
		$sql = "SELECT COUNT(id_jobs)
				FROM `jobs`
				WHERE ( CONVERT(`title` USING utf8) LIKE '%" . $search . "%' AND `status` = 'active') ";
	} elseif ( $status == 'active' ) {
		$sql = "SELECT COUNT(id_jobs)
				FROM jobs 
				WHERE status = 'active' ";
	} elseif ( empty( $status ) && empty( $id_user ) ) {
		$sql = "SELECT COUNT(id_jobs)
				FROM jobs ";
	} elseif ( empty( $status ) && ! empty( $id_user ) ) {
		$sql = "SELECT COUNT(id_jobs)
				FROM jobs 
				WHERE id_user = $id_user";
	}

	$result = db_sql_run( $sql );
	$result = mysqli_fetch_assoc( $result );

	return $result['COUNT(id_jobs)'];
}


function count_cat() {

	$sql = "SELECT COUNT(id_category)
			FROM category ;";

	$result = db_sql_run( $sql );
	$result = mysqli_fetch_assoc( $result );

	return $result['COUNT(id_category)'];
}


function get_jobs( $start_index, $status, $search = '', $id_user = '' ) {
	if ( ! empty( $search ) ) {
		$sql = "SELECT jobs.*, user.*
				FROM `jobs` JOIN user ON user.id_user = jobs.id_user 
				WHERE ( CONVERT(`title` USING utf8) LIKE '%" . $search . "%' AND `status` = 'active') 
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	} elseif ( $status == 'active' ) {
		$sql = "SELECT jobs.*, user.*
				FROM jobs JOIN user ON user.id_user = jobs.id_user 
				WHERE status = 'active' 
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	} elseif ( empty( $status ) && empty( $id_user ) ) {
		$sql = "SELECT jobs.*, user.*
				FROM jobs JOIN user ON user.id_user = jobs.id_user 
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	} elseif ( empty( $status ) && ! empty( $id_user ) ) {
		$sql = "SELECT jobs.*, user.*
				FROM jobs JOIN user ON user.id_user = jobs.id_user 
				WHERE jobs.id_user = $id_user
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	}

	return db_sql_run( $sql );
}


function jobs_start_index_for_page( $page ) {
	return ( $page * JOBS_PER_PAGE ) - JOBS_PER_PAGE;
}


function get_categories_list( $start_index ) {
	$sql = "SELECT * FROM category ORDER BY name LIMIT " . $start_index . "," . CATS_PER_PAGE;

	return db_sql_run( $sql );
}


/**
 * Kick user if NOT logged in!
 *
 * Redirect user to 'Home Page' with header( 'Location' ).
 * Execute an 'exit()' command to prevent further code execution.
 *
 * @return null
 */
function kick_if_not_logged_in() {
	if ( empty( $_SESSION['id_user'] ) ) {
		header( 'Location: ' . BASE_URL );
		exit();
	}

	return null;
}

/**
 * Kick user if logged in!
 *
 * Redirect user to 'Home Page' with header( 'Location' ).
 * Execute an 'exit()' command to prevent further code execution.
 *
 * @return null
 */
function kick_if_logged_in() {
	if ( ! empty( $_SESSION['id_user'] ) ) {
		header( 'Location: ' . BASE_URL );
		exit();
	}

	return null;
}


function query_relate_jobs( $id_current_job ) {
	$conn   = open_db_conn();
	$sql    = "SELECT * FROM `category_job` WHERE id_jobs = $id_current_job";
	$result = mysqli_query( $conn, $sql );
	$result = mysqli_fetch_assoc( $result );
	if ( isset( $result['id_category'] ) ) {
		$id_cat = $result['id_category'];

	} else {
		return null;
	}

	$sql = "SELECT category_job.*, jobs.status
                FROM `category_job` 
                JOIN jobs  on category_job.id_jobs = jobs.id_jobs 
                WHERE id_category = $id_cat
                and status ='active'";

	$result = mysqli_query( $conn, $sql );
	//$job_to_cat_arr = mysqli_fetch_assoc( $result );

	if ( mysqli_num_rows( $result ) > 0 ) {
		$similar_jobs_num     = NUMBER_OF_RELEATED_JOBS;
		$similar_jobs_id_list = array();
		if ( mysqli_num_rows( $result ) > 0 ) {
			while ( $job_to_cat = mysqli_fetch_assoc( $result ) ) {
				if ( $similar_jobs_num == 0 ) {
					break;
				}
				if ( $job_to_cat['id_jobs'] != $id_current_job ) {
					$similar_jobs_num       -= 1;
					$similar_jobs_id_list[] = $job_to_cat['id_jobs'];
				}
			}

			$sql = 'SELECT jobs.*, user.*
                    FROM `jobs` 
                    JOIN user ON user.id_user = jobs.id_user
                    WHERE  `id_jobs` IN (' . implode( ',', array_map( 'intval', $similar_jobs_id_list ) ) . ')';

			return mysqli_query( $conn, $sql );
		}
	}
}


function login_if_valid_cookies() {
	if ( empty( $_SESSION['id_user'] ) && isset( $_COOKIE["validator"] ) && isset( $_COOKIE["user_id"] ) ) {
		$validator_from_cookie = $_COOKIE["validator"];
		$user_id_from_cookie   = $_COOKIE["user_id"];

		$sql = "SELECT validator,validator_date,company_name,email FROM user WHERE id_user = " . $user_id_from_cookie . ";";

		$conn   = open_db_conn();
		$result = mysqli_query( $conn, $sql );
		if ( mysqli_num_rows( $result ) > 0 ) {
			$result = mysqli_fetch_assoc( $result );

			$validator      = $result['validator'];
			$validator_date = $result['validator_date'];
			$company_name   = $result['company_name'];
			$email          = $result['email'];

			if ( $validator_date > time() && $validator == $validator_from_cookie ) {
				$_SESSION['id_user'] = intval( $_COOKIE["user_id"] );

				//check is admin
				if ( is_admin( $email ) ) {
					$_SESSION['is_admin'] = true;
				}

				//check is company
				if ( ! empty( $company_name ) ) {
					$_SESSION['is_company'] = true;
				}

				return true;
			}

			return false;
		}
	}
}


function is_admin( $email ) {
	$split_mail = explode( '@', $email );
	if ( $split_mail[1] == 'devrix.com' ) {
		return true;
	}

	return false;
}


function convertImage( $originalImage, $outputImage, $quality ) {

	$errors = array();

	// jpg, png, gif or bmp?
	$img_info = getimagesize( $originalImage );
	$ext      = $img_info['mime'];
	$ext      = explode( '/', $ext );
	$ext      = $ext[1];

	if ( preg_match( '/jpg|jpeg/i', $ext ) ) {
		$imageTmp = imagecreatefromjpeg( $originalImage );
	} else if ( preg_match( '/png/i', $ext ) ) {
		$imageTmp = imagecreatefrompng( $originalImage );
	} else if ( preg_match( '/gif/i', $ext ) ) {
		$imageTmp = imagecreatefromgif( $originalImage );
	} else if ( preg_match( '/bmp/i', $ext ) ) {
		$imageTmp = imagecreatefrombmp( $originalImage );
	} else {
		$errors[] = 'not correct format';
	}

	if ( ! $imageTmp ) {
		$errors[] = 'Failed to load fake format';
	}

	// quality is a value from 0 (worst) to 100 (best)
	imagejpeg( $imageTmp, $outputImage, $quality );
	imagedestroy( $imageTmp );

	return $errors;
}


function upload_img( $file, $new_file_name ) {
	$target_dir   = "tmp/";
	$target_file  = $target_dir . basename( $file["fileToUpload"]["name"] );
	$img_errors[] = array();

	$uploadOk      = 1;
	$imageFileType = strtolower( pathinfo( $target_file, PATHINFO_EXTENSION ) );

	// Check if image file is a actual image or fake image
	$check = getimagesize( $file["fileToUpload"]["tmp_name"] );
	if ( ! $check ) {
		$img_errors[] = "File is not an image.";
		$uploadOk     = 0;
	}

	// Allow certain file formats
	if ( $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		$img_errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		$uploadOk     = 0;
	}

	// Check if $uploadOk is set to 0 by an error
	if ( $uploadOk == 0 ) {
		$img_errors[] = "Sorry, your file was not uploaded.";
	} else {
		// if everything is ok, try to upload file
		if ( move_uploaded_file( $file["fileToUpload"]["tmp_name"], $target_file ) ) {
			$save_dir = "img/company/" . $new_file_name;
			$result   = convertImage( $target_file, $save_dir, 100 );
			foreach ( $result as $error ) {
				if ( ! empty( $error ) ) {
					$img_errors[] = $error;
				}
			}
		} else {
			$img_errors[] = "Sorry, there was an error uploading your file.";
		}
	}

	return $img_errors;

}
