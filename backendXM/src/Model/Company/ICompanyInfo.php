<?php


namespace App\Model\Company;


interface ICompanyInfo
{

	public function __construct(string $symbol, string $name, string $description = null);

	public function getSymbol(): string;

	public function getName(): string;

	public function getDescription(): string;


}
