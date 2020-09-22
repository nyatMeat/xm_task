<?php


namespace App\Model\CalendarPeriod;


interface CalendarPeriodInterface
{
	public function getStart(): \DateTimeInterface;

	public function getEnd(): \DateTimeInterface;
}
