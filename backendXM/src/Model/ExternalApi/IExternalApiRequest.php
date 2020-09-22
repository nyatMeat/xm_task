<?php


namespace App\Model\ExternalApi;


use GuzzleHttp\Psr7\Response;

interface IExternalApiRequest
{

	public function getMethod(): string;

	public function getRequestBody();

	public function getRequestHeaders(): array;

	public function getQueryParams(): array;

	public function getRequestUri(): string;

	public function convertResponseToDto(Response $response);
}
