<?php

date_default_timezone_set(DEF_TIME_ZONE);


function date_difference($date_1, $difference_format = '%a')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create();

    $interval = date_diff($datetime2, $datetime1);

    return $interval->format($difference_format);
}


/**
 * Extract and Check domain validation.
 *
 * @param string $domain_or_url Accepts url address or domain.
 *
 * @return bool|string With the valid domain if domain is valid and boolean 'FALSE' if the domain is not valid.
 */
function extract_valid_domaine($domain_or_url)
{
    //extract domain from url
    $domain_or_url = trim($domain_or_url);
    $domain_or_url = str_replace(array('http://', 'https://'),'', $domain_or_url);
    $domain_or_url_arr = explode('/', $domain_or_url);
    $domain = trim($domain_or_url_arr[0]);

    // check pattern
    $valid_pattern = (preg_match("/^(?!\-)(?:(?:[a-zA-Z\d][a-zA-Z\d\-]{0,61})?[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/", $domain));

    // check DNS records
    $valid_dns = dns_get_record($domain);

    if ($valid_pattern && $valid_dns) {
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
function extract_valid_phone($phone)
{
    //remove chars - / ( ) and space
    $phone = trim($phone);
    $phone = str_replace(array(' ', '(', ')', '-', '/', '\\'), '', $phone);

    if (preg_match('/^(\+359|0)\s?8(\d{2}\s\d{3}\d{3}|[789]\d{7})$/', $phone)) {
        return str_replace('+359', 0, $phone);
    } else {
        return false;
    }
}
