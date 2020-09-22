<?php


namespace App\Model\FinancialInfo;


abstract class AbstractHistoricalItem implements IHistoricalItem
{
	/** @var int */
	protected $date;
	/** @var float */
	protected $open;
	/** @var float */
	protected $close;
	/** @var float */
	protected $low;
	/** @var float */
	protected $high;
	/** @var float */
	protected $volume;

	final public function jsonSerialize()
	{
		return [
			'date' => $this->getDate(),
			'open' => $this->getOpen(),
			'close' => $this->getClose(),
			'low' => $this->getLow(),
			'high' => $this->getHigh(),
			'volume' => $this->getVolume(),
		];
	}

	/**
	 * @return int
	 */
	public function getDate(): int
	{
		return $this->date;
	}

	/**
	 * @param int $date
	 * @return AbstractHistoricalItem
	 */
	public function setDate(int $date): AbstractHistoricalItem
	{
		$this->date = $date;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getOpen(): float
	{
		return $this->open;
	}

	/**
	 * @param float $open
	 * @return AbstractHistoricalItem
	 */
	public function setOpen(float $open): AbstractHistoricalItem
	{
		$this->open = $open;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getClose(): float
	{
		return $this->close;
	}

	/**
	 * @param float $close
	 * @return AbstractHistoricalItem
	 */
	public function setClose(float $close): AbstractHistoricalItem
	{
		$this->close = $close;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getLow(): float
	{
		return $this->low;
	}

	/**
	 * @param float $low
	 * @return AbstractHistoricalItem
	 */
	public function setLow(float $low): AbstractHistoricalItem
	{
		$this->low = $low;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getHigh(): float
	{
		return $this->high;
	}

	/**
	 * @param float $high
	 * @return AbstractHistoricalItem
	 */
	public function setHigh(float $high): AbstractHistoricalItem
	{
		$this->high = $high;
		return $this;
	}

	/**
	 * @return float
	 */
	public function getVolume(): float
	{
		return $this->volume;
	}

	/**
	 * @param float $volume
	 * @return AbstractHistoricalItem
	 */
	public function setVolume(float $volume): AbstractHistoricalItem
	{
		$this->volume = $volume;
		return $this;
	}


}
