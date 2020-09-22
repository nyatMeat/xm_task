<?php


namespace App\Controller\Api;


use App\Event\AfterGetHistoricalDataRequestEvent;
use App\Helper\ApiHelper;
use App\Model\Api\Financial\GetHistoricalDataRequest;
use App\Model\CalendarPeriod\CalendarPeriodCustom;
use App\Service\FinancialDataStorage\YahooFinancialDataStorage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FinancialController extends AbstractController
{
	/** @var YahooFinancialDataStorage */
	protected $financialDataStorage;

	/**
	 * FinancialController constructor.
	 * @param YahooFinancialDataStorage $financialDataStorage
	 */
	public function __construct(YahooFinancialDataStorage $financialDataStorage)
	{
		$this->financialDataStorage = $financialDataStorage;
	}

	/**
	 * @Route("/api/financial-info/for-period")
	 * @param Request $request
	 * @param ValidatorInterface $validator
	 * @param EventDispatcherInterface $dispatcher
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getHistoricalInfo(Request $request, ValidatorInterface $validator, EventDispatcherInterface $dispatcher)
	{
		$filter = GetHistoricalDataRequest::newFromArray($request->request->all());
		$validation = $validator->validate($filter);
		if (count($validation))
		{
			return $this->json(ApiHelper::convertValidationErrorsToApiError($validation), Response::HTTP_BAD_REQUEST);
		}
		$result = $this->financialDataStorage->getFinancialDataForInterval($filter->getCompanySymbol(), new CalendarPeriodCustom($filter->getDateFrom(), $filter->getDateTo()));
		$dispatcher->dispatch(new AfterGetHistoricalDataRequestEvent($filter), AfterGetHistoricalDataRequestEvent::NAME);
		return $this->json($result);
	}


}
