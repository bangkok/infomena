<?php 
function pluralforms($numeric, $many, $one, $two)
{
    $numeric = (int) abs($numeric);
    if ( $numeric % 100 == 1 || ($numeric % 100 > 20) && ( $numeric % 10 == 1 )) return $one;
    if ( $numeric % 100 == 2 || ($numeric % 100 > 20) && ( $numeric % 10 == 2 )) return $two;
    if ( $numeric % 100 == 3 || ($numeric % 100 > 20) && ( $numeric % 10 == 3 ) ) return $two;
    if ( $numeric % 100 == 4 || ($numeric % 100 > 20) && ( $numeric % 10 == 4 ) ) return $two;
    return $many;
}

?>