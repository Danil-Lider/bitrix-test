<?php

//define("STOP_STATISTICS", true);
//define("NO_KEEP_STATISTIC", true);
//define("NO_AGENT_STATISTIC", true);
require($_SERVER["DOCUMENT_ROOT"] . '/bitrix/modules/main/include/prolog_before.php');

use classes\SypexGeo;

$SG = new SypexGeo();

$info = $SG->get_info('109.194.214.18');

print_r($info);


//$geo = file_get_contents('https://api.sypexgeo.net/jsonp/123.45.67.89');
//// Все данные о IP
//print_r($geo);

//echo 123;
