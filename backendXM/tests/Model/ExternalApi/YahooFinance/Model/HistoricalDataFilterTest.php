<?php

namespace App\Tests\Model\ExternalApi\YahooFinance\Model;

use App\Model\CalendarPeriod\CalendarPeriodCustom;
use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use PHPUnit\Framework\TestCase;

class HistoricalDataFilterTest extends TestCase
{

	public function testToArray()
	{
		$r = HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-05-05'), new \DateTimeImmutable('2020-06-06')));
		$params = $r->toArray();
		$this->assertEquals('1d', $params['frequency']);
		$this->assertEquals('history', $params['filter']);
		$this->assertEquals('S', $params['symbol']);
		$this->assertEquals(1588629600, $params['period1']);
		$this->assertEquals(1591394400, $params['period2']);
	}

	public function testCreateDailyHistoryFilter()
	{
		$r = HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-05-05'), new \DateTimeImmutable('2020-06-06')));
		$this->assertEquals('1d', $r->getFrequency());
		$this->assertEquals('history', $r->getFilter());
		$this->assertEquals('S', $r->getSymbol());
		$this->assertEquals(1588629600, $r->getPeriod1());
		$this->assertEquals(1591394400, $r->getPeriod2());
	}
}
