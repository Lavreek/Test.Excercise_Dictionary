<?php
	
	include "EXOne.php";

	// не знаю прикол ли это задание и не понимаю, правильно ли я его решил

	$options = getopt("v::", ["year::"]);

	if (isset($options['year']))
		echo (new ExcerciseOne($options['year']))->getAnswer();
	else
		throw new Exception("Try use --year=\"number\" param to execute method", 1);
		