<?php


namespace App\Model\ExternalApi\YahooFinance;


class FinanceApiSettings
{
	/** @var string */
	protected $rapidApiKey;
	/** @var string */
	protected $baseUri;

	/**
	 * ApiSettings constructor.
	 * @param string $rapidApiKey
	 * @param string $baseUri
	 */
	public function __construct(string $rapidApiKey, string $baseUri)
	{
		$this->rapidApiKey = $rapidApiKey;
		$this->baseUri = $baseUri;
	}

	public static function newFromParams(array $params)
	{
		return new static($params['yahoo_rapid_api_key'], $params['yahoo_finance_base_url']);
	}

	/**
	 * @return string
	 */
	public function getRapidApiKey(): string
	{
		return $this->rapidApiKey;
	}

	/**
	 * @return string
	 */
	public function getBaseUri(): string
	{
		return $this->baseUri;
	}

	/**
	 * @return string
	 */
	public function getApiHost()
	{
		return parse_url($this->getBaseUri(), PHP_URL_HOST);
	}


}
