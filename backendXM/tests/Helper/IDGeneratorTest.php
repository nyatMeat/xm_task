<?php

namespace App\Tests\Helper;

use App\Helper\IDGenerator;
use PHPUnit\Framework\TestCase;

class IDGeneratorTest extends TestCase
{

	public function testGUID()
	{
		$guid = IDGenerator::GUID();
		$this->assertTrue((is_string($guid) && (preg_match('/^[a-z\d]{8}(-[a-z\d]{4}){4}[a-z\d]{8}$/i', $guid) === 1)));
	}
}
