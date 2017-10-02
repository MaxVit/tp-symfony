<?php
// src/App/Repository/ProductRepository.php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function findByFiveLast()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:Product p ORDER BY p.id ASC'
            )->setMaxResults(5)
            ->getResult();
    }
}
