<?php


namespace App\Service\FinancialDataStorage;


use App\Model\CalendarPeriod\CalendarPeriodInterface;
use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use App\Model\ExternalApi\YahooFinance\Request\Stock\V2\GetHistoricalData;
use App\Model\Interfaces\IFinancialDataStorage;
use App\Service\ExternalApi\YahooRapidApiExecutor;
use Psr\Log\LoggerInterface;

class YahooFinancialDataStorage implements IFinancialDataStorage
{

	/** @var YahooRapidApiExecutor */
	protected $yahooApi;
	/** @var LoggerInterface */
	protected $logger;

	/**
	 * YahooFinancialDataStorage constructor.
	 * @param YahooRapidApiExecutor $yahooApi
	 * @param LoggerInterface $logger
	 */
	public function __construct(YahooRapidApiExecutor $yahooApi, LoggerInterface $logger)
	{
		$this->yahooApi = $yahooApi;
		$this->logger = $logger;
	}

	/**
	 * @param string $companyUniqueData
	 * @param CalendarPeriodInterface $calendarPeriod
	 * @return array
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getFinancialDataForInterval(string $companyUniqueData, CalendarPeriodInterface $calendarPeriod): array
	{
		$res = $this->yahooApi->execute(new GetHistoricalData(HistoricalDataFilter::createDailyHistoryFilter($companyUniqueData, $calendarPeriod)));
		if (!$res->isSuccessful())
		{
			throw new \RuntimeException('Error occurred while fetching data from api');
		}
		return $res->getResultAsDto();
	}
}
