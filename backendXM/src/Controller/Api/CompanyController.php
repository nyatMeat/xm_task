<?php


namespace App\Controller\Api;


use App\Service\CompanyRepository\NasdaqCompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CompanyController extends AbstractController
{
	/**
	 * @var NasdaqCompanyRepository
	 */
	private $repository;

	public function __construct(NasdaqCompanyRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * Get company list
	 * @Route("/api/companies", name="companies_list")
	 * @return JsonResponse
	 */
	public function getList()
	{
		return $this->json($this->repository->getCompanyList());
	}

	/**
	 * Get company by symbol
	 * @param $symbol
	 * @Route("/api/companies/{symbol}", name="company_by_symbol")
	 * @return JsonResponse
	 */
	public function getBySymbol(string $symbol)
	{
		return $this->json($this->repository->getCompanyInfoBySymbol($symbol));
	}
}
