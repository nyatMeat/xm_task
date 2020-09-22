<?php


namespace App\Service\CompanyRepository;


use App\Model\Company\CompanyInfo;
use App\Model\Company\ICompanyInfo;
use App\Model\Interfaces\CompanyRepository;
use JsonMachine\JsonMachine;
use Psr\Log\LoggerInterface;

class NasdaqCompanyRepository implements CompanyRepository
{

	/** @var string */
	protected $nasdaqCompanySource;
	/** @var LoggerInterface */
	protected $logger;

	/**
	 * NasdaqCompanyService constructor.
	 * @param string $nasdaqCompanySource
	 * @param LoggerInterface $logger
	 */
	public function __construct(string $nasdaqCompanySource, LoggerInterface $logger)
	{
		$this->nasdaqCompanySource = $nasdaqCompanySource;
		$this->logger = $logger;
	}


	/**
	 * @param string $symbol
	 * @return ICompanyInfo|CompanyInfo
	 */
	public function getCompanyInfoBySymbol(string $symbol): ?ICompanyInfo
	{
		$res = null;
		foreach (JsonMachine::fromFile($this->nasdaqCompanySource) as $item)
		{
			if (isset($item['Symbol']) && $item['Symbol'] === $symbol)
			{
				return new CompanyInfo($item['Symbol'], $item['Company Name'] ?? '', $item['Security Name'] ?? '');
			}
		}
		return $res;
	}

	/**
	 * @return ICompanyInfo[]|CompanyInfo[]
	 */
	public function getCompanyList(): array
	{
		$res = [];
		foreach (JsonMachine::fromFile($this->nasdaqCompanySource) as $item)
		{
			if(!isset($item['Symbol'])){
				continue;
			}
			$res[] = new CompanyInfo($item['Symbol'], $item['Company Name'] ?? '', $item['Security Name'] ?? '');
		}
		return $res;
	}
}
