<?php


namespace App\Model\FinancialInfo;


interface IHistoricalItem extends \JsonSerializable
{
	public function getDate(): int;

	public function getOpen(): float;

	public function getClose(): float;

	public function getVolume(): float;

	public function getHigh(): float;

	public function getLow(): float;
}
