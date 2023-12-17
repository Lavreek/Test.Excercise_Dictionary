<?php
	mb_internal_encoding("UTF-8");

	include "EXThird.php";

	$options = getopt("v::", ["word::"]);

	if (isset($options['word']))
	{
		$lower = $options['word'];

		// $lower = mb_convert_case($lower, MB_CASE_LOWER, "UTF-8");

		$a = str_split($lower, 2);
		
		new ExcerciseThird($a);
	}
	else
		throw new Exception("Try use --word=\"symbols\" param to execute method", 1);
		