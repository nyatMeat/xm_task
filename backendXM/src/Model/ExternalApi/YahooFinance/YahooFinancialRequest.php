<?php


namespace App\Model\ExternalApi\YahooFinance;


use App\Model\ExternalApi\IExternalApiRequest;
use GuzzleHttp\Psr7\Response;

abstract class YahooFinancialRequest implements IExternalApiRequest
{
	public function getMethod(): string
	{
		return 'get';
	}

	public function getQueryParams(): array
	{
		return [];
	}

	public function getRequestBody()
	{
		return '';
	}

	public function getRequestHeaders(): array
	{
		return [];
	}

	public function convertResponseToDto(Response $response)
	{
		return null;
	}

	public function getRequestUri(): string
	{
		return '';
	}
}
