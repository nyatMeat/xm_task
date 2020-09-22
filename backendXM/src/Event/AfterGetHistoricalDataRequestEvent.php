<?php


namespace App\Event;


use App\Model\Api\Financial\GetHistoricalDataRequest;
use Symfony\Contracts\EventDispatcher\Event;

class AfterGetHistoricalDataRequestEvent extends Event
{
	public const NAME = 'after_get_historical_data_event';


	/** @var GetHistoricalDataRequest */
	protected $requestData;

	/**
	 * AfterGetHistoricalDataRequest constructor.
	 * @param GetHistoricalDataRequest $requestData
	 */
	public function __construct(GetHistoricalDataRequest $requestData)
	{
		$this->requestData = $requestData;
	}

	/**
	 * @return GetHistoricalDataRequest
	 */
	public function getRequestData(): GetHistoricalDataRequest
	{
		return $this->requestData;
	}


}
