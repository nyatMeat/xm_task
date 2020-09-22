<?php


namespace App\Model\ExternalApi\YahooFinance\Request\Stock\V2;


use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use App\Model\ExternalApi\YahooFinance\YahooFinancialRequest;
use App\Model\FinancialInfo\Yahoo\YahooHistoricalItem;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\StreamWrapper;
use JsonMachine\JsonMachine;

class GetHistoricalData extends YahooFinancialRequest
{
	/** @var HistoricalDataFilter */
	private $filter;

	/**
	 * GetHistoricalData constructor.
	 * @param HistoricalDataFilter $filter
	 */
	public function __construct(HistoricalDataFilter $filter)
	{
		$this->filter = $filter;
	}


	public function getMethod(): string
	{
		return 'get';
	}

	public function getRequestUri(): string
	{
		return 'stock/v2/get-historical-data';
	}

	public function getQueryParams(): array
	{
		return $this->filter->toArray();
	}

	/**
	 * @param Response $response
	 * @return YahooHistoricalItem[]
	 */
	public function convertResponseToDto(Response $response)
	{
		$result = [];
		foreach (JsonMachine::fromStream(StreamWrapper::getResource($response->getBody()), '/prices') as $arr)
		{
			$result[] = (new YahooHistoricalItem())
				->setDate($arr['date'])
				->setOpen($arr['open'])
				->setClose($arr['close'])
				->setHigh($arr['high'])
				->setLow($arr['low'])
				->setVolume($arr['volume']);
		}
		return $result;
	}
}
