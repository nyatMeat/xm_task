<?php


namespace App\Model\Interfaces;


use App\Model\Company\ICompanyInfo;

interface CompanyRepository
{
	/**
	 * @param string $symbol
	 * @return ICompanyInfo|null
	 */
	public function getCompanyInfoBySymbol(string $symbol): ?ICompanyInfo;

	public function getCompanyList(): array;

}
