<?php
// src/App/Repository/ProductRepository.php
namespace App\Repository;

use Doctrine\ORM\EntityRepository;


class CommentRepository extends EntityRepository
{
    public function findByIdRelated($id)
    {
        $qb = $this->createQueryBuilder('comment')
            ->select('comment')
            ->where('comment.idRelated = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()
            ->getResult();
    }
}