<?php

namespace App\Tests\Model\ExternalApi\YahooFinance;

use App\Model\ExternalApi\YahooFinance\FinanceApiSettings;
use PHPUnit\Framework\TestCase;

class FinanceApiSettingsTest extends TestCase
{

	public function testNewFromParams()
	{
		$i = FinanceApiSettings::newFromParams(['yahoo_rapid_api_key' => '123', 'yahoo_finance_base_url' => 'https://apidojo-yahoo-finance-v1.p.rapidapi.com']);
		$this->assertEquals('123', $i->getRapidApiKey());
		$this->assertEquals('https://apidojo-yahoo-finance-v1.p.rapidapi.com', $i->getBaseUri());
		$this->assertEquals('apidojo-yahoo-finance-v1.p.rapidapi.com', $i->getApiHost());
	}

}
