<?php
	class ExcerciseOne
	{
		const start_year = 2020;

		const common_year = 365;
		const common_day = 24;

		const flight_hour_time = 2;
		const rest_hour_time = 6;
		const flight_time_zones = 3;

		private $time_zones;
		private $start_hours;
		private $find_year;
		
		function __construct($year)
		{
			$this->find_year = $year;
			$this->start_hours = 12;
			$this->time_zones = 0;
		}

		private function howManyTime($year)
		{
			$_366 = fmod($year, 4);

			$hours = ExcerciseOne::common_year * ExcerciseOne::common_day;

			if ($_366 == 0)
				return $hours += ExcerciseOne::common_day;

			return $hours;
		}

		private function oneFlight($hours) // за 2 часа на 3 часовых пояса
		{	
			return $hours + ExcerciseOne::flight_hour_time;
		}

		private function oneRest($hours)
		{
			return $hours + ExcerciseOne::rest_hour_time;
		}

		private function moscowTime($pilotStartTime, $timeZones)
		{
			return fmod($pilotStartTime + $timeZones, 24);
		}

		private function answerString($mode, $year, $NewYear_StartTime, $restTime, $time_zones, $flights, $rests, $hours, int $alltime)
		{
			if ($mode == 0)
				$mode = ["after flight", "1 jan", "1 jan"];
			else
				$mode = ["in rest", "31 dec", "1 jan"];

			$moscow = $this->moscowTime($NewYear_StartTime, $time_zones);

			return "In $year year. i work ".$hours." hours. I can celebrate ny $mode[0] from $NewYear_StartTime:00 $mode[1] to ".$restTime.":00 $mode[2]! In Moscow time: $moscow:00 Time Zone: -".$time_zones." hours. In this year i flight: ".$flights." times and rest: ".$rests." times. My next flight in ".$restTime.":00\n";
		}

		public function getAnswer()
		{
			if ($this->find_year >= ExcerciseOne::start_year)
			{
				$time_array = [];
				$year_difference = ($this->find_year - ExcerciseOne::start_year);

				for ($i = 0; $i <= $year_difference; $i++) { 
					$year = 2020 + $i;
					$time_array += [(string)$year => $this->howManyTime($year)];
				}

				$start_hours = $this->start_hours;
				$time_zones = $this->time_zones;
				
				$action = "flight";

				foreach ($time_array as $key => $value)
				{
					$flight = 0;
					$rest = 0;
					$answer = "";

					while (true)
					{
						if ($action == "flight")
						{
							if ($this->oneFlight($start_hours) > $value)
							{
								$NewYear_StartTime = fmod(ExcerciseOne::common_day - ($value - $start_hours), 24);
								$rest_time = ExcerciseOne::rest_hour_time - ($value - $start_hours);

								$answer = $this->answerString(0, //mode
									$key, $NewYear_StartTime, $rest_time, $time_zones, $flight, $rest, $start_hours, $value);

								$start_hours = $start_hours - $value;

								break;
							}
							else
							{
								$time_zones = fmod($time_zones + 3, 24);

								$start_hours = $this->oneFlight($start_hours);
								$flight++;

								$action = "rest";
							}
						}
						if ($action == "rest")
						{
							if ($this->oneRest($start_hours) > $value)
							{
								$NewYear_StartTime = fmod(ExcerciseOne::common_day - ($value - $start_hours), 24);
								$rest_time = ExcerciseOne::rest_hour_time - ($value - $start_hours);

								$answer = $this->answerString(1, //mode
									$key, $NewYear_StartTime, $rest_time, $time_zones, $flight, $rest, $start_hours, $value);

								$start_hours = $start_hours - $value;

								break;
							}
							else
							{
								$start_hours = $this->oneRest($start_hours);
								$rest++;

								$action = "flight";
							}
						}
					}
				}
				return $answer;
			}
			echo "Прекрасный пилот ещё не появился";
		}
	}