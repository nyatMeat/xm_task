<?php


namespace App\Model\Api;


class ApiError implements IApiError
{
	/** @var string|null */
	protected $description;
	/** @var string|null */
	protected $property;
	/** @var array */
	protected $params = [];

	/**
	 * @return string|null
	 */
	public function getDescription(): ?string
	{
		return $this->description;
	}

	/**
	 * @param string|null $description
	 * @return ApiError
	 */
	public function setDescription(?string $description): ApiError
	{
		$this->description = $description;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getProperty(): ?string
	{
		return $this->property;
	}

	/**
	 * @param string|null $property
	 * @return ApiError
	 */
	public function setProperty(?string $property): ApiError
	{
		$this->property = $property;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @param array $params
	 * @return ApiError
	 */
	public function setParams(array $params): ApiError
	{
		$this->params = $params;
		return $this;
	}




}
