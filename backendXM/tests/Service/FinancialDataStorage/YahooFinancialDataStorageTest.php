<?php

namespace App\Tests\Service\FinancialDataStorage;

use App\Model\CalendarPeriod\CalendarPeriodCustom;
use App\Model\ExternalApi\ExternalApiResult;
use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use App\Model\ExternalApi\YahooFinance\Request\Stock\V2\GetHistoricalData;
use App\Model\FinancialInfo\IHistoricalItem;
use App\Service\ExternalApi\YahooRapidApiExecutor;
use App\Service\FinancialDataStorage\YahooFinancialDataStorage;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class YahooFinancialDataStorageTest extends TestCase
{

	/**
	 * @var YahooFinancialDataStorage
	 */
	protected $instance;
	/** @var MockObject */
	protected $apiMock;

	public function setUp(): void
	{
		$this->apiMock = $this->getMockBuilder(YahooRapidApiExecutor::class)->disableOriginalConstructor()
			->getMock();
		$this->instance = new YahooFinancialDataStorage($this->apiMock, $this->getMockBuilder(LoggerInterface::class)
			->getMock());
	}

	public function testGetFinancialDataForInterval()
	{
		$apiResult = new ExternalApiResult(
			new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('GOOGL', new CalendarPeriodCustom(new \DateTimeImmutable('2020-09-10'), new \DateTimeImmutable('2020-09-20'))))
			, new Response(200, [], file_get_contents(__DIR__ . '/../../TestData/HistoryItems/historyResponse.json')));
		$this->apiMock->method('execute')->willReturn($apiResult);
		$result = $this->instance->getFinancialDataForInterval('GOOGL', new CalendarPeriodCustom(new \DateTimeImmutable('2020-09-10'), new \DateTimeImmutable('2020-09-20')));
		$this->assertCount(8, $result);
		/** @var IHistoricalItem $first */
		$first = $result[0];
		$this->assertInstanceOf(IHistoricalItem::class, $first);
		$this->assertEquals(1600435800, $first->getDate());
		$this->assertEquals(1451.0899658203125, $first->getClose());
		$this->assertEquals(1488.300048828125, $first->getOpen());
		$this->assertEquals(3152000, $first->getVolume());
		$this->assertEquals(1495.199951171875, $first->getHigh());
	}

	public function testGetFinancialDataForIntervalError()
	{
		$apiResult = new ExternalApiResult(
			new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter('GOOGL', new CalendarPeriodCustom(new \DateTimeImmutable('2020-09-10'), new \DateTimeImmutable('2020-09-20'))))
			, new Response(500, [], ''));
		$this->apiMock->method('execute')->willReturn($apiResult);
		try
		{
			$result = $this->instance->getFinancialDataForInterval('GOOGL', new CalendarPeriodCustom(new \DateTimeImmutable('2020-09-10'), new \DateTimeImmutable('2020-09-20')));
		} catch (\Exception $e)
		{
			$this->assertInstanceOf(\RuntimeException::class, $e);
		}

	}
}
