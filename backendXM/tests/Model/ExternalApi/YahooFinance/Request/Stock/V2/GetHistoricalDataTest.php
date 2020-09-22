<?php

namespace App\Tests\Model\ExternalApi\YahooFinance\Request\Stock\V2;

use App\Model\Api\Financial\GetHistoricalDataRequest;
use App\Model\CalendarPeriod\CalendarPeriodCustom;
use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use App\Model\ExternalApi\YahooFinance\Request\Stock\V2\GetHistoricalData;
use App\Model\FinancialInfo\Yahoo\YahooHistoricalItem;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class GetHistoricalDataTest extends TestCase
{

	public function testConvertResponseToDto()
	{
		$request = new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-09-10'), new \DateTimeImmutable('2020-09-20'))));

		$response = new Response(200, [], file_get_contents(__DIR__ . '/../../../../../../TestData/HistoryItems/historyResponse.json'));
		$result = $request->convertResponseToDto($response);
		$first = $result[0];

		$this->assertInstanceOf(YahooHistoricalItem::class, $first);
		$this->assertEquals(1600435800, $first->getDate());
		$this->assertEquals(1451.0899658203125, $first->getClose());
		$this->assertEquals(1488.300048828125, $first->getOpen());
		$this->assertEquals(3152000,$first->getVolume());
		$this->assertEquals(1495.199951171875, $first->getHigh());
	}

	public function testGetMethod()
	{
		$request = new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-05-05'), new \DateTimeImmutable('2020-06-06'))));
		$this->assertEquals('get', $request->getMethod());
	}

	public function testGetQueryParams()
	{
		$request = new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-05-05'), new \DateTimeImmutable('2020-06-06'))));
		$params = $request->getQueryParams();
		$this->assertEquals('1d', $params['frequency']);
		$this->assertEquals('history', $params['filter']);
		$this->assertEquals('S', $params['symbol']);
		$this->assertEquals(1588629600, $params['period1']);
		$this->assertEquals(1591394400, $params['period2']);
	}

	public function testGetRequestUri()
	{
		$request = new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('S',
			new CalendarPeriodCustom(new \DateTimeImmutable('2020-05-05'), new \DateTimeImmutable('2020-06-06'))));
		$this->assertEquals('stock/v2/get-historical-data', $request->getRequestUri());
	}
}
