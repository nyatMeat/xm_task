<?php


namespace App\Model\Interfaces;


use App\Model\ExternalApi\IExternalApiRequest;
use App\Model\ExternalApi\IExternalApiResult;

/**
 * Interface IApiExecutor
 * @package App\Model\Interfaces
 */
interface IApiExecutor
{
	public function execute(IExternalApiRequest $request): IExternalApiResult;
}
