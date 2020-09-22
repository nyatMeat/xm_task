<?php


namespace App\Model\Interfaces;


interface IDto
{
	/**
	 * @param array $array
	 * @return static
	 */
	public static function newFromArray(array $array);
}
