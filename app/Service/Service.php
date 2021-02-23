<?php

namespace App\Service;

use App\Component\File;
use App\Controller\InterfaceController;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class Service
{

	/**
	 * @Inject
	 * @var EntityManager
	 */
	protected $entityManager;

	/**
	 * @var EntityRepository
	 */
    protected $entityRepository;

	/**
	 * BUSCA PELA HASH
	 *
	 * @param $hash
	 * @return bool|object|null
	 */
	public function hash($hash)
	{
		if (!is_object($this->entityRepository))
			return false;

		$entity = $this->entityRepository->findOneBy(['hash' => $hash]);

		if (is_object($entity) && $entity->getId())
			return $entity;

		return false;
	}

    /**
     * @param $documents
     * @param $entity
     * @param $path
     * @return array[]
     */
	public function documentPreview($documents, $entity, $path): array
    {
        $data = [];
        $dataConfig = [];
        $dataThumbTags = [];
        foreach ($documents as $key => $document)
        {
            $data[] = $path . $entity->getHash() . '/' . $document->getFile();
            $dataConfig[] = [
                'caption' => $document->getDocument(),
                'size' => $document->getSize(),
                'downloadUrl' => $path . $entity->getHash() . '/' . $document->getFile(),
                'type' => File::getType($document->getFile()),
                'key' => $document->getId(),
                'extra' => $document->getId()
            ];
            $dataThumbTags[] = [
                'document_id' => $document->getId()
            ];
        }

        return [
            'preview' => $data,
            'previewConfig' => $dataConfig,
            'initialPreviewThumbTags' => $dataThumbTags
        ];
    }

    /**
     * @param $data
     * @return mixed
     * @throws ORMException
     */
    public function updateDocument(array $data)
    {
        if (isset($data['title'])) {
            foreach ($data['title'] as $key => $title) {
                if ($key === '{document_id}') {
                    continue;
                }
                $key = substr($key, 1, -1);
                $document = $this->entityRepository->find($key);
                if (!is_null($document)) {
                    $document->setDocument($title);
                    $this->entityManager->persist($document);
                }
            }
        }
        return $data;
    }

    /**
     * @return EntityRepository
     */
    public function getEntityRepository(): EntityRepository
    {
        return $this->entityRepository;
    }

    public function convertDate($data): ?\Datetime
    {
        if ($data === null) {
            return null;
        }

        [$d, $m, $Y] = explode('/', $data);
        if (checkdate($m, $d, $Y)) {
            $d = new \Datetime($Y . '-' . $m . '-' . $d);
            return $d;
        }
    }

}
