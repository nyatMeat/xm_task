<?php


namespace App\Service\ExternalApi;


use App\Model\ExternalApi\ExternalApiResult;
use App\Model\ExternalApi\IExternalApiRequest;
use App\Model\ExternalApi\IExternalApiResult;
use App\Model\ExternalApi\YahooFinance\FinanceApiSettings;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\Psr7\build_query;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Psr\Log\LoggerInterface;

class YahooRapidApiExecutor
{

	/** @var Client */
	private $client;
	/** @var FinanceApiSettings */
	private $config;

	/**
	 * @var LoggerInterface
	 */
	private $logger;

	public function __construct(array $yahooConfig, LoggerInterface $logger)
	{
		$this->config = FinanceApiSettings::newFromParams($yahooConfig);
		$this->logger = $logger;
		$this->initClient();
	}

	/**
	 * @param IExternalApiRequest $request
	 * @return IExternalApiResult
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function execute(IExternalApiRequest $request): IExternalApiResult
	{
		$guzzleRequest = (new Request($request->getMethod(), (new Uri($request->getRequestUri()))
			->withQuery(build_query($request->getQueryParams())), $request->getRequestHeaders(), $request->getRequestBody()));
		try
		{
			$this->logger->info('Send request to JsonPlaceholder',
				[
					'method' => $guzzleRequest->getMethod(),
					'uri' => $guzzleRequest->getUri(),
					'headers' => $guzzleRequest->getHeaders(),
					'body' => $guzzleRequest->getBody()
				]);
			$response = $this->client->send($guzzleRequest);

		} catch (RequestException $e)
		{
			$this->logger->info('Something went wrong while sending request to JsonPlaceholder',
				[
					'method' => $guzzleRequest->getMethod(),
					'uri' => $guzzleRequest->getUri(),
					'headers' => $guzzleRequest->getHeaders(),
					'body' => $guzzleRequest->getBody(),
					'httpCode' => $e->getCode(),
					'errorTrace' => $e->getTraceAsString(),
					'errorMessage' => $e->getMessage()
				]);
			$response = $e->getResponse();
		}
		return new ExternalApiResult($request, $response);
	}


	protected function initClient()
	{
		if (!$this->client)
		{
			if (!$this->config)
			{
				throw new \RuntimeException('Yahoo config is not valid');
			}
			$this->client = new Client(['base_uri' => $this->config->getBaseUri(), 'headers' => [
				'X-RapidAPI-Key' => $this->config->getRapidApiKey(),
				'X-RapidAPI-Host' => $this->config->getApiHost()
			]]);
		}
	}
}
