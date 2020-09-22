<?php


namespace App\Model\Api\Financial;


use App\Validator\Constraints as AcmeAssert;
use App\Model\Interfaces\IDto;
use Symfony\Component\Validator\Constraints as Assert;

class GetHistoricalDataRequest implements IDto
{
	/**
	 * @Assert\Email(message="Email must be valid format")
	 * @Assert\NotBlank(message="Email must be present")
	 * @var string
	 */
	protected $email;
	/**
	 * @Assert\NotBlank(message="Company symbol must be present")
	 * @AcmeAssert\CompanyExist
	 * @var string
	 */
	protected $companySymbol;

	/**
	 * @Assert\NotBlank(message="Date from must be present")
	 * @Assert\LessThanOrEqual(value="today", message="Date from must be less or equal current")
	 * @var \DateTimeInterface
	 */
	protected $dateFrom;

	/**
	 * @Assert\NotBlank(message="Date end must be present")
	 * @Assert\LessThanOrEqual(value="today", message="Date end must be less or equal current")
	 * @Assert\Expression(expression="this.getDateTo() >= this.getDateFrom()", message="Date to must be higher than date from")
	 * @Assert\Type(type="\DateTimeInterface", message="End date must be present as datetime")
	 * @var \DateTimeInterface
	 */
	protected $dateTo;

	public static function newFromArray(array $array)
	{
		$r = new static();
		if (isset($array['companySymbol']))
		{
			$r->setCompanySymbol($array['companySymbol']);
		}
		if (isset($array['dateFrom']))
		{
			if (is_string($array['dateFrom']))
			{
				$r->setDateFrom(new \DateTimeImmutable($array['dateFrom']));
			}
			if (is_numeric($array['dateFrom']))
			{
				$r->setDateFrom((new \DateTimeImmutable())->setTimestamp($array['dateFrom']));
			}
		}
		if (isset($array['dateTo']))
		{
			if (is_string($array['dateTo']))
			{
				$r->setDateTo(new \DateTimeImmutable($array['dateTo']));
			}
			if (is_numeric($array['dateTo']))
			{
				$r->setDateTo((new \DateTimeImmutable())->setTimestamp($array['dateTo']));
			}
		}
		if (isset($array['email']))
		{
			$r->setEmail($array['email']);
		}

		return $r;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return GetHistoricalDataRequest
	 */
	public function setEmail(string $email): GetHistoricalDataRequest
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getCompanySymbol(): string
	{
		return $this->companySymbol;
	}

	/**
	 * @param string $companySymbol
	 * @return GetHistoricalDataRequest
	 */
	public function setCompanySymbol(string $companySymbol): GetHistoricalDataRequest
	{
		$this->companySymbol = $companySymbol;
		return $this;
	}

	/**
	 * @return \DateTimeInterface
	 */
	public function getDateFrom(): \DateTimeInterface
	{
		return $this->dateFrom;
	}

	/**
	 * @param \DateTimeInterface $dateFrom
	 * @return GetHistoricalDataRequest
	 */
	public function setDateFrom(\DateTimeInterface $dateFrom): GetHistoricalDataRequest
	{
		$this->dateFrom = $dateFrom;
		return $this;
	}

	/**
	 * @return \DateTimeInterface
	 */
	public function getDateTo(): \DateTimeInterface
	{
		return $this->dateTo;
	}

	/**
	 * @param \DateTimeInterface $dateTo
	 * @return GetHistoricalDataRequest
	 */
	public function setDateTo(\DateTimeInterface $dateTo): GetHistoricalDataRequest
	{
		$this->dateTo = $dateTo;
		return $this;
	}


}
