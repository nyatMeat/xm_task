<?php


namespace App\Helper;


use App\Model\Api\ApiError;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ApiHelper
{
	/**
	 * @param ConstraintViolationListInterface $constraintViolation
	 * @return ApiError[]
	 */
	public static function convertValidationErrorsToApiError(ConstraintViolationListInterface $constraintViolation): array
	{

		$r = [];
		/** @var ConstraintViolationInterface $item */
		foreach ($constraintViolation as $item)
		{
			$r[] = (new ApiError())
				->setParams($item->getParameters())
				->setProperty($item->getPropertyPath())
				->setDescription($item->getMessage());
		}
		return $r;
	}
}
