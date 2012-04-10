<?
function zodiak($month,$day) {
//   $sign = array('Козерог', 'Водолей', ... , 'Стрелец'); // год начинается Козерогом
   $sign = array('CAPRICORN', 'AQUARIUS', 'PISCES','ARIES', 'TAURUS', 'GEMINI', 'CANCER', 'LEO', 'VIRGO', 'LIBRA', 'SCORPIO', 'SAGITTARIUS');
   $signstart = array(1=>21, 2=>20, 3=>21, 4=>21, 5=>22, 6=>22, 7=>23, 8=>23, 9=>24, 10=>24, 11=>23, 12=>22 ); // первый день нового знака для каждого месяца
   return $day < $signstart[$month] ? $sign[$month-1] : $sign[$month%12]; // конец декабря - опять Козерог
} 
?>