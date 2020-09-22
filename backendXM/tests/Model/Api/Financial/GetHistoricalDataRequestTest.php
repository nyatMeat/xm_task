<?php

namespace App\Tests\Model\Api\Financial;

use App\Model\Api\Financial\GetHistoricalDataRequest;
use PHPUnit\Framework\TestCase;

class GetHistoricalDataRequestTest extends TestCase
{

	public function testNewFromArray()
	{
		$json = '{
    "email": "alexander.kaluzhskiy@gmail.com",
    "dateFrom": "2020-09-10",
    "dateTo": "2020-09-20",
    "companySymbol": "GOOGL"
}';
		$item = GetHistoricalDataRequest::newFromArray(json_decode($json, true));
		$this->assertEquals('GOOGL', $item->getCompanySymbol());
		$this->assertEquals('alexander.kaluzhskiy@gmail.com', $item->getEmail());
	}
}
