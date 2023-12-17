<?php

	class ExcerciseTwo
	{
		function __construct($tiker_type)
		{
			switch ($tiker_type) {
				case 'SPY': case 'BLD': case 'BIL':
					$this->readfile($tiker_type);
					break;
				default:
					throw new Exception("Unknown tiker type: ".$tiker_type , 1);
			}
		}

		private function readFile($tiker)
		{
			$fhandle = fopen("https://query1.finance.yahoo.com/v7/finance/download/".$tiker."?period1=728265600&period2=1643673600&interval=1d&events=history&includeAdjustedClose=true", "r");

			$make_header = true;
			$header = [];
			$variables = [];

			while ($text = fgetcsv($fhandle, 9999, ","))
			{
				if (isset($make_header))
				{
					$header += $text;
					unset($make_header);
				}
				else
				{
					array_push($variables, $text);
				}			
			}

			fclose($fhandle);
			
			$success_trade = 0;

			foreach ($variables as $key => $value) {
				if ($value[1] < $value[4])
				{
					$success_trade++;
				}
			}

			print_r ("Count of success percent trade offers: ".number_format($success_trade / count($variables) * 100, 2, '.', '')."%");
		}
	}