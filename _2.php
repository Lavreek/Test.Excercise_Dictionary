<?php
	
	include "EXTwo.php";

	$options = getopt("v::", ["tiker::"]);

	if (isset($options['tiker']))
	{
		$a = $options['tiker'];
		new ExcerciseTwo(strtoupper($a));
	}
	else
		throw new Exception("Try use --tiker=\"type\" param to execute method", 1);
		