<?php
namespace Common\Util\DateTime;

use DateTime;
use Exception;

class AustrianHolidayChecker
{
	/**
	 * @param DateTime $dateTime
	 * @return bool
	 * @throws Exception
	 */
	public function isHoliday(DateTime $dateTime)
	{
		if (!extension_loaded('calendar'))
		{
			throw new Exception('Austrian holiday checker needs PHPs "calendar" extension');
		}

		$dayMonth = $dateTime->format('dm');

		$easterSunday = new DateTime();
		$easterSunday->setTimestamp(
			easter_date($dateTime->format('Y'))
		);

		// holidays
		return in_array(
			$dayMonth,
			array(
				// static dates
				'0101', // neujahr
				'0601', // heilige 3 könige
				'0105', // staatsfeiertag
				'1508', // mariä himmelfahrt
				'2610', // nationalfeiertag
				'0111', // allerheiligen
				'0812', // mariä empfängnis
				'2512', // weihnachten
				'2612', // stefanitag
				// dynamic dates
				(clone $easterSunday)->modify('+1 day')->format('dm'), // ostermontag -> 1 day after ostersonntag
				(clone $easterSunday)->modify('+39 day')->format('dm'), // christi himmelfahrt -> 39 days after ostersonntag
				(clone $easterSunday)->modify('+50 day')->format('dm'), // pfingstmontag -> 50 days after ostersonntag
				(clone $easterSunday)->modify('+60 day')->format('dm') // fronleichnam -> 60 days after ostersonntag
			)
		);

	}
}