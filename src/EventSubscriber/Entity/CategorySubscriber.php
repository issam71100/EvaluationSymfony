<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Artwork;
use App\Entity\Category;
use App\Entity\Exposition;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class CategorySubscriber implements EventSubscriber
{
	private $stringService;

	public function __construct(StringService $stringService)
	{
		$this->stringService = $stringService;
	}

	public function prePersist(LifecycleEventArgs $args): void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if (!$entity instanceof Category) {
			return;
		} else {
			// création du slug
			$name = $entity->getName();

			if ($name != null) {
				$slug = $this->stringService->getSlug($name);
				$entity->setSlug($slug);
			}
		}
	}

	public function getSubscribedEvents(): array
	{
		return [
			Events::prePersist,
		];
	}
}
