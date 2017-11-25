<?php
/* $str = 'Not Good';

// previous to PHP 5.1.0 you would compare with -1, instead of false
if (($timestamp = strtotime($str)) === false) {
echo "The string ($str) is bogus";
} else {
echo "$str == " . date('l dS \o\f F Y h:i:s A', $timestamp);
}
 */
$timestamp = strtotime(str_replace('/', '-', '27/05/1990'));
$date123   = date_create_from_format('d/m/y', '27/05/1990');
echo "The string = { $date123   } ";
echo ("<br>");
echo strtotime("now"), "\n";
echo strtotime("10 September 2000"), "\n";
echo strtotime("+1 day"), "\n";
echo strtotime("+1 week"), "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"), "\n";
echo strtotime("next Thursday"), "\n";
echo strtotime("last Monday"), "\n";
