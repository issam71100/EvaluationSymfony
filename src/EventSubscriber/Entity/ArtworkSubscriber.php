<?php

namespace App\EventSubscriber\Entity;

use App\Entity\Artwork;
use App\Service\FileService;
use App\Service\StringService;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArtworkSubscriber implements EventSubscriber
{
	/*
	 * injecter un service dans un autre service hors contrôleur
	 *    - créer une propriété de classe
	 *    - créer un constructeur qui reçoit en paramètre le service à injecter
	 *    - dans le constructeur, lier le paramètre à la propriété de classe
	 */
	private $stringService;
	private $fileService;

	public function __construct(StringService $stringService, FileService $fileService)
	{
		$this->stringService = $stringService;
		$this->fileService = $fileService;
	}

	/*
	 * souscripteur d'entité doctrine
	 *  - la méthode doit retourner un tableau des événements à écouter
	 *      - prePersist / postPersist : avant ou après une insertion
	 *      - preUpdate / postUpdate : avant ou après une modification
	 *      - preRemove / postRemove : avant ou après une suppression
	 *      - postLoad : après l'instanciation d'une entité
	 *  - les méthodes liées aux événements doivent reprendre strictement le nom de l'événement à écouter
	 *  - toutes les méthodes recoivent un paramètre de type LifecycleEventArgs
	 *  - référencer le souscripteur dans config/services.yaml
	 */
	public function prePersist(LifecycleEventArgs $args): void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if (!$entity instanceof Artwork) {
			return;
		} else {
			// création du slug
			$name = $entity->getName();

			if ($name != null) {
				$slug = $this->stringService->getSlug($name);
				$entity->setSlug($slug);
			}

			// transfert d'image
			$image = $entity->getImage();

			if ($image instanceof UploadedFile) {
				$this->fileService->upload($image, 'img/product');

				// mise à jour de la propriété image
				$entity->setImage($this->fileService->getFileName());
			}
		}
	}

	public function postLoad(LifecycleEventArgs $args): void
	{
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if (!$entity instanceof Artwork) {
			return;
		} else {
			// création d'une propriété dynamique pour stocker le nom de l'image
			$entity->prevImage = $entity->getImage();
		}
	}

	public function preUpdate(LifecycleEventArgs $args): void
	{
		die();
		// par défaut, les souscripteurs écoutent toutes les entités
		$entity = $args->getObject();

		// si l'entité n'est pas Product
		if (!$entity instanceof Artwork) {
			return;
		} else {
			// si une image a été sélectionnée
			if ($entity->getImage() instanceof UploadedFile) {
				// transfert de la nouvelle image
				$this->fileService->upload($entity->getImage(), 'uploads/img/artwork');
				$entity->setImage($this->fileService->getFileName());

				// supprimer l'ancienne image
				if (file_exists("img/product/{$entity->prevImage}")) {
					$this->fileService->remove('img/product', $entity->prevImage);
				}
			}
			// si aucune image n'a été sélectionnée
			else {
				$entity->setImage($entity->prevImage);
			}
		}
	}

	public function getSubscribedEvents(): array
	{
		return [
			Events::prePersist,
			Events::postLoad,
			Events::preUpdate,
		];
	}
}
