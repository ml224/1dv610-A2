<?php

	class DateTimeView {
		public function show() {

		$year = date("Y");
		$month = date("F"); 
		$monthDay = date("j") . "th";
		$weekDay = date("l");
		$hours = date("H");
		$minutes = date("i");
		$seconds = date("s");

		$timeString = "$weekDay, the $monthDay of $month $year, The time is $hours:$minutes:$seconds";

		return '<p>' . $timeString . '</p>';
	}


}