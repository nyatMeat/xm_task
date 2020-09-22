<?php


namespace App\Model\Api;


interface IApiError
{
	public function getProperty(): ?string;

	public function getDescription(): ?string;

	public function getParams(): array;
}
