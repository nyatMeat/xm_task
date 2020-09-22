<?php


namespace App\Model\CalendarPeriod;


class CalendarPeriodCustom implements CalendarPeriodInterface
{
	/** @var \DateTimeInterface */
	protected $start;
	/** @var \DateTimeInterface */
	protected $end;

	/**
	 * CalendarPeriodCustom constructor.
	 * @param \DateTimeInterface $start
	 * @param \DateTimeInterface $end
	 */
	public function __construct(\DateTimeInterface $start, \DateTimeInterface $end)
	{
		$this->start = $start;
		$this->end = $end;
	}

	/**
	 * @return \DateTimeInterface
	 */
	public function getStart(): \DateTimeInterface
	{
		return $this->start;
	}

	/**
	 * @return \DateTimeInterface
	 */
	public function getEnd(): \DateTimeInterface
	{
		return $this->end;
	}


}
