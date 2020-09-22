<?php


namespace App\Model\Interfaces;


use App\Model\CalendarPeriod\CalendarPeriodInterface;
use App\Model\FinancialInfo\IHistoricalItem;

interface IFinancialDataStorage
{
	/**
	 * @param string $companyUniqueData
	 * @param CalendarPeriodInterface $calendarPeriod
	 * @return IHistoricalItem[]
	 */
	public function getFinancialDataForInterval(string $companyUniqueData, CalendarPeriodInterface $calendarPeriod): array;
}
