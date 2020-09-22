<?php


namespace App\Utils;


use App\Helper\IDGenerator;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class UniqueLogProcessor
{
	protected $correlationId;

	public function __construct()
	{
		return $this->correlationId = IDGenerator::GUID();
	}

	public function processRecord(array $record)
	{
		$record['extra']['correlationId'] = $this->correlationId;

		return $record;
	}

	public function onKernelException(ExceptionEvent $event)
	{
		if ($event->hasResponse())
		{
			$event->getResponse()->headers->add(["correlationId" => $this->correlationId]);
		}
	}

	/**
	 * @param KernelEvent $event
	 */
	public function onKernelResponse(KernelEvent $event)
	{
		if ($event->getRequest() !== null)
		{
			$event->getResponse()->headers->add(["correlationId" => $this->correlationId]);
		}
	}
}
