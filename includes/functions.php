<?php

date_default_timezone_set(DEF_TIME_ZONE);


function date_difference($date_1, $difference_format = '%a')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create();

    $interval = date_diff($datetime2, $datetime1);

    return $interval->format($difference_format);
}