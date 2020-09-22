<?php


namespace App\Validator\Constraints;


use App\Service\CompanyRepository\NasdaqCompanyRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class CompanyExistValidator extends ConstraintValidator
{
	/**
	 * @var NasdaqCompanyRepository
	 */
	private $repository;

	public function __construct(NasdaqCompanyRepository $repository)
	{
		$this->repository = $repository;
	}

	/**
	 * @param string $value
	 * @param Constraint $constraint
	 */
	public function validate($value, Constraint $constraint)
	{

		if (!$constraint instanceof CompanyExist)
		{
			throw new UnexpectedTypeException($constraint, CompanyExist::class);
		}

		if (null === $value || '' === $value)
		{
			return;
		}

		if (!is_string($value))
		{
			// throw this exception if your validator cannot handle the passed type so that it can be marked as invalid
			throw new UnexpectedValueException($value, 'string');

			// separate multiple types using pipes
			// throw new UnexpectedValueException($value, 'string|int');
		}

		$company = $this->repository->getCompanyInfoBySymbol($value);
		if (!$company)
		{
			$this->context->buildViolation("Company with symbol is not exists")
				->setParameter('{{ string }}', $value)
				->addViolation();
		}
	}
}
