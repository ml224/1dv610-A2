<?php

	class DateTimeView {
		private $year;
		private $month;
		private $monthDay;
		private $weekDay;
		private $timeStamp;

		public function show() {
		$dateArray = getDate();
		
		$year = $dateArray["year"];
		$month = $dateArray["month"]; 
		$monthDay = $dateArray["mday"];
		$weekDay = $dateArray["weekday"];
		$hours = $dateArray["hours"];
		$minutes = $dateArray["minutes"];
		$seconds = $dateArray["seconds"];

		$timeString = "$weekDay, the $monthDay of $month $year. The time is $hours:$minutes:$seconds";

		return '<p>' . $timeString . '</p>';
	}


}