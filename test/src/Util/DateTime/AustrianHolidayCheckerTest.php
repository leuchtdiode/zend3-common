<?php
namespace CommonTest\Util\DateTime;

use Common\Util\DateTime\AustrianHolidayChecker;
use CommonTest\Base;
use DateTime;
use Exception;

class AustrianHolidayCheckerTest extends Base
{
	/**
	 * @var array
	 */
	private static $holidayDates = [
		'2019' => [
			'2019-01-01',
			'2019-01-06',
			'2019-04-22',
			'2019-05-01',
			'2019-05-30',
			'2019-06-10',
			'2019-06-20',
			'2019-08-15',
			'2019-10-26',
			'2019-11-01',
			'2019-12-08',
			'2019-12-25',
			'2019-12-26',
		],
		'2020' => [
			'2020-01-01',
			'2020-01-06',
			'2020-04-13',
			'2020-05-01',
			'2020-05-21',
			'2020-06-01',
			'2020-06-11',
			'2020-08-15',
			'2020-10-26',
			'2020-11-01',
			'2020-12-08',
			'2020-12-25',
			'2020-12-26',
		],
	];

	/**
	 */
	public function years()
	{
		return [
			[ 2019 ],
			[ 2020 ],
		];
	}

	/**
	 * @param int $year
	 * @dataProvider years
	 * @throws Exception
	 */
	public function test_whole_year($year)
	{
		$date = new DateTime();
		$date->setDate($year, 1, 1);

		$checker = new AustrianHolidayChecker();

		while (true)
		{
			if ($date->format('Y') != $year)
			{
				break;
			}

			$shouldBeHoliday = in_array(
				$date->format('Y-m-d'),
				self::$holidayDates[$year]
			);
			$this->assertEquals(
				$shouldBeHoliday,
				$checker->isHoliday($date),
				sprintf(
					'%s should be %s holiday',
					$date->format('Y-m-d'),
					$shouldBeHoliday ? 'a' : 'no'
				)
			);

			$date->modify('+1 day');
		}
	}
}