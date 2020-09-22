<?php


namespace App\Model\ExternalApi\YahooFinance\Model;


use App\Model\CalendarPeriod\CalendarPeriodInterface;

class HistoricalDataFilter
{
	/** @var string */
	protected $frequency;
	/** @var int */
	protected $period1;
	/** @var int */
	protected $period2;
	/** @var string */
	protected $symbol;
	/** @var string */
	protected $filter;

	/**
	 * @param string $symbol
	 * @param CalendarPeriodInterface $calendarPeriod
	 * @return HistoricalDataFilter
	 */
	public static function createDailyHistoryFilter(string $symbol, CalendarPeriodInterface $calendarPeriod)
	{
		return (new static())
			->setSymbol($symbol)
			->setPeriod1($calendarPeriod->getStart()->getTimestamp())
			->setPeriod2($calendarPeriod->getEnd()->getTimestamp())
			->setFilter('history')
			->setFrequency('1d');
	}

	/**
	 * @return string
	 */
	public function getFrequency(): string
	{
		return $this->frequency;
	}

	/**
	 * @param string $frequency
	 * @return HistoricalDataFilter
	 */
	public function setFrequency(string $frequency): HistoricalDataFilter
	{
		$this->frequency = $frequency;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPeriod1(): int
	{
		return $this->period1;
	}

	/**
	 * @param int $period1
	 * @return HistoricalDataFilter
	 */
	public function setPeriod1(int $period1): HistoricalDataFilter
	{
		$this->period1 = $period1;
		return $this;
	}

	/**
	 * @return int
	 */
	public function getPeriod2(): int
	{
		return $this->period2;
	}

	/**
	 * @param int $period2
	 * @return HistoricalDataFilter
	 */
	public function setPeriod2(int $period2): HistoricalDataFilter
	{
		$this->period2 = $period2;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSymbol(): string
	{
		return $this->symbol;
	}

	/**
	 * @param string $symbol
	 * @return HistoricalDataFilter
	 */
	public function setSymbol(string $symbol): HistoricalDataFilter
	{
		$this->symbol = $symbol;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilter(): string
	{
		return $this->filter;
	}

	/**
	 * @param string $filter
	 * @return HistoricalDataFilter
	 */
	public function setFilter(string $filter): HistoricalDataFilter
	{
		$this->filter = $filter;
		return $this;
	}


	public function toArray()
	{
		return [
			'symbol' => $this->getSymbol(),
			'period1' => $this->getPeriod1(),
			'period2' => $this->getPeriod2(),
			'frequency' => $this->getFrequency(),
			'filter' => $this->getFilter(),
		];
	}

}
