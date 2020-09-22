<?php


namespace App\EventSubscriber;


use App\Event\AfterGetHistoricalDataRequestEvent;
use App\Service\CompanyRepository\NasdaqCompanyRepository;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AfterGetHistoricalDataRequest implements EventSubscriberInterface
{
	/**
	 * @var \Swift_Mailer
	 */
	private $mailer;
	/**
	 * @var LoggerInterface
	 */
	private $logger;
	/**
	 * @var string
	 */
	private $emailFromDefault;
	/**
	 * @var NasdaqCompanyRepository
	 */
	private $companyRepository;

	public function __construct(string $emailFromDefault, \Swift_Mailer $mailer, NasdaqCompanyRepository $companyRepository, LoggerInterface $logger)
	{
		$this->mailer = $mailer;
		$this->logger = $logger;
		$this->emailFromDefault = $emailFromDefault;
		$this->companyRepository = $companyRepository;
	}

	public static function getSubscribedEvents()
	{
		return [
			AfterGetHistoricalDataRequestEvent::NAME => 'notifyUser',
		];
	}

	public function notifyUser(AfterGetHistoricalDataRequestEvent $event)
	{
		$dateFormat = 'Y-m-d';
		$requestData = $event->getRequestData();
		$company = $this->companyRepository->getCompanyInfoBySymbol($requestData->getCompanySymbol());
		if (!$company)
		{
			$this->logger->error('Company not found by symbol', ['companySymbol' => $requestData->getCompanySymbol()]);
			return;
		}
		try
		{
			$count = $this->mailer->send((new \Swift_Message(
				"The submitted company name {$company->getName()}",
				"From {$requestData->getDateFrom()->format($dateFormat)} to {$event->getRequestData()->getDateTo()->format($dateFormat)}"))
				->setTo($requestData->getEmail())
				->setFrom($this->emailFromDefault));
			if (!$count)
			{
				$this->logger->error('Message was not sent to user', [
					'companySymbol' => $requestData->getCompanySymbol(),
					'userEmail' => $requestData->getEmail()]);
			}
		} catch (\Exception $e)
		{
			$this->logger->critical('Something went wrong while sending message to user', [
				'companySymbol' => $requestData->getCompanySymbol(),
				'userEmail' => $requestData->getEmail(),
				'errorMessage' => $e->getMessage(),
				'errorTrace' => $e->getTraceAsString()
			]);
		}
	}
}
