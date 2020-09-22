<?php


namespace App\Model\ExternalApi;



use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class ExternalApiResult implements IExternalApiResult
{

	/** @var Response|null */
	protected $response;
	/** @var IExternalApiRequest */
	protected $request;

	public function __construct(IExternalApiRequest $request, ?ResponseInterface $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function isSuccessful(): bool
	{
		return !(!$this->getResponse() || $this->getResponse()->getStatusCode() >= 400);
	}

	public function getResponse(): ?Response
	{
		return $this->response;
	}

	public function getRequest(): IExternalApiRequest
	{
		return $this->request;
	}

	public function getResultAsDto()
	{
		return $this->request->convertResponseToDto($this->response);
	}
}
