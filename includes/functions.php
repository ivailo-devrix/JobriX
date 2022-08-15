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
 * Extract and Check domain validation
 * @param string $domain_or_url <p>
 * accepts url address or  domain
 * </p>
 * @return string with the valid domain if domain is valid and boolean 'FALSE' if the domain is not valid.
 */
function extract_valid_domaine($domain_or_url)
{
    //extract domain from url
    $domain_or_url = str_replace('http://', '', $domain_or_url);
    $domain_or_url = str_replace('https://', '', $domain_or_url);
    $domain_or_url_arr = explode('/', $domain_or_url);
    $domain = $domain_or_url_arr[0];

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