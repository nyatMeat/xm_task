<?php


namespace App\Model\Company;


class CompanyInfo implements ICompanyInfo
{
	/** @var string */
	protected $symbol;
	/** @var string */
	protected $name;
	/** @var string */
	protected $description = '';

	/**
	 * CompanyInfo constructor.
	 * @param string $symbol
	 * @param string $name
	 * @param string $description
	 */
	public function __construct(string $symbol, string $name, ?string $description = null)
	{
		$this->symbol = $symbol;
		$this->name = $name;
		$this->description = $description;
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
	 * @return CompanyInfo
	 */
	public function setSymbol(string $symbol): CompanyInfo
	{
		$this->symbol = $symbol;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return CompanyInfo
	 */
	public function setName(string $name): CompanyInfo
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 * @return CompanyInfo
	 */
	public function setDescription(string $description): CompanyInfo
	{
		$this->description = $description;
		return $this;
	}


}
