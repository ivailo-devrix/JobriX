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


function pagination( $number_of_items, $page_url ) {
	$las_page_num = ceil( ( $number_of_items / JOBS_PER_PAGE ) );

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


function active_jobs() {
	$sql = "SELECT COUNT(status)
			FROM jobs
			WHERE status = 'active'; ";

	$result = db_sql_run( $sql );
	$result = mysqli_fetch_assoc( $result );

	return $result['COUNT(status)'];
}


function get_jobs( $start_index, $status, $search ) {
	if ( ! empty( $search ) ) {
		$sql = "SELECT jobs.*, user.company_name, user.company_site 
				FROM `jobs` JOIN user ON user.id_user = jobs.id_user 
				WHERE ( CONVERT(`title` USING utf8) LIKE '%" . $search . "%' AND `status` = 'active') 
				LIMIT 0,20";
	} elseif ( $status == 'active' ) {
		$sql = "SELECT jobs.*, user.company_name, user.company_site 
				FROM jobs JOIN user ON user.id_user = jobs.id_user 
				WHERE status = 'active' 
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	} elseif ( empty( $status ) ) {
		$sql = "SELECT jobs.*, user.company_name, user.company_site 
				FROM jobs JOIN user ON user.id_user = jobs.id_user 
				LIMIT " . $start_index . "," . JOBS_PER_PAGE;
	}

	return db_sql_run( $sql );
}


function jobs_start_index_for_page( $page ) {
	return ( $page * JOBS_PER_PAGE ) - JOBS_PER_PAGE;
}


function get_categories_list( $start_index ) {
	$sql = "SELECT * FROM category LIMIT " . $start_index . "," . CATS_PER_PAGE;

	return db_sql_run( $sql );
}