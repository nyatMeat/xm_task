<?php

namespace App\Tests\Service\CompanyRepository;

use App\Model\Company\ICompanyInfo;
use App\Service\CompanyRepository\NasdaqCompanyRepository;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class NasdaqCompanyRepositoryTest extends TestCase
{
	/** @var NasdaqCompanyRepository */
	protected $instance;

	protected function setUp(): void
	{
		$this->instance = new NasdaqCompanyRepository(__DIR__ . '/../../TestData/Companies/companies.json',
			$this->getMockBuilder(LoggerInterface::class)->getMock());
	}


	public function testGetCompanyList()
	{
		$list = $this->instance->getCompanyList();
		$this->assertCount(6, $list);
		$this->assertTrue(isset($list[0]));
		$first = $list[0];
		$this->assertInstanceOf(ICompanyInfo::class, $first);
		$this->assertEquals('AAIT', $first->getSymbol());
		$this->assertEquals('iShares MSCI All Country Asia Information Technology Index Fund', $first->getName());
	}

	public function testGetCompanyInfoBySymbol()
	{
		$item = $this->instance->getCompanyInfoBySymbol('AAIT');
		$this->assertInstanceOf(ICompanyInfo::class, $item);
		$this->assertEquals('AAIT', $item->getSymbol());
		$this->assertEquals('iShares MSCI All Country Asia Information Technology Index Fund', $item->getName());

		$item = $this->instance->getCompanyInfoBySymbol('sdffsdfdsfds');
		$this->assertNull($item);
	}
}
