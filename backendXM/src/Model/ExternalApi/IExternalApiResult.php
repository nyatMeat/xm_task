<?php


namespace App\Model\ExternalApi;


use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

interface IExternalApiResult
{
	public function __construct(IExternalApiRequest $request, ?ResponseInterface $response);

	public function getRequest(): IExternalApiRequest;

	public function isSuccessful(): bool;

	public function getResultAsDto();

	public function getResponse(): ?Response;


}
