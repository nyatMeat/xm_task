<?php

namespace App\Tests\EventSubsriber;

use App\Event\AfterGetHistoricalDataRequestEvent;
use App\EventSubscriber\AfterGetHistoricalDataRequest;
use App\Model\Api\Financial\GetHistoricalDataRequest;
use App\Model\ExternalApi\YahooFinance\Model\HistoricalDataFilter;
use App\Service\CompanyRepository\NasdaqCompanyRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class AfterGetHistoricalDataRequestTest extends TestCase
{

	/** @var AfterGetHistoricalDataRequest */
	protected $instance;
	/** @var MockObject */
	protected $swiftmailerMock;

	public function setUp(): void
	{
		$this->swiftmailerMock = $this->getMockBuilder(\Swift_Mailer::class)->disableOriginalConstructor()->getMock();
		$companyRepository = new NasdaqCompanyRepository(__DIR__ . '/../TestData/Companies/companies.json',
			$this->getMockBuilder(LoggerInterface::class)
				->getMock());
		$this->instance = new AfterGetHistoricalDataRequest('alex@mail.ru', $this->swiftmailerMock,
			$companyRepository, $this->getMockBuilder(LoggerInterface::class)->getMock());
	}

	public function testNotifyUserSuccess()
	{
		$event = new AfterGetHistoricalDataRequestEvent((new GetHistoricalDataRequest())
			->setDateFrom(new \DateTimeImmutable('2020-09-09'))
			->setDateTo(new \DateTimeImmutable('2020-09-20'))
			->setEmail('alex@alex.ru')
			->setCompanySymbol('AAVL'));
		$this->swiftmailerMock->expects($this->once())->method('send')->willReturn(1);
		$this->instance->notifyUser($event);
	}


	public function testNotifyUserFailureSend()
	{
		$event = new AfterGetHistoricalDataRequestEvent((new GetHistoricalDataRequest())
			->setDateFrom(new \DateTimeImmutable('2020-09-09'))
			->setDateTo(new \DateTimeImmutable('2020-09-20'))
			->setEmail('alex@alex.ru')
			->setCompanySymbol('34453543'));
		$this->swiftmailerMock->expects($this->never())->method('send');
		$this->instance->notifyUser($event);
	}

	public function testNotifyUserFailureCompanyNotFound()
	{
		$event = new AfterGetHistoricalDataRequestEvent((new GetHistoricalDataRequest())
			->setDateFrom(new \DateTimeImmutable('2020-09-09'))
			->setDateTo(new \DateTimeImmutable('2020-09-20'))
			->setEmail('alex@alex.ru')
			->setCompanySymbol('AAVL'));
		$this->swiftmailerMock->expects($this->once())->method('send')->willReturn(0);
		$this->instance->notifyUser($event);
	}
}
