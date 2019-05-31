<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiHelperService
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * ApiHelperService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param Request $request
     * @param         $entity
     * @param array   $possibleChange
     * @return bool|string
     */
    public function putEntity(Request $request, $entity, array $possibleChange)
    {
        try {
            $changed = '';

            foreach ($possibleChange as $change) {
                if ($value = $request->query->get($change)) {
                    $method = 'set' . ucfirst($change);
                    $entity->$method($value);

                    $this->entityManager->persist($entity);
                    $this->entityManager->flush();

                    $changed .= "changed the \"{$change}\" field to \"{$value}\",";
                }
            }

            $changed = ($changed != '') ? substr($changed, 0, -1) : 'nothing has been replaced';

            return new Response($changed, 200);
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), $exception->getCode());
        }
    }
}