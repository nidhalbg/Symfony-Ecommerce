<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    public function getAllProducts()
    {
        return $this->createQueryBuilder('p')
            ->getQuery()
            ->execute();
    }

    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM AppBundle:Product p ORDER BY p.name ASC'
            )
            ->getResult();
    }

    public function getLastProducts(int $limit = 20)
    {
        return $this->getEntityManager()
            ->createQuery(
                "SELECT p FROM AppBundle:Product p ORDER BY p.id DESC"
            )
            ->setMaxResults($limit)
            ->getResult();
    }

    public function getLastProductsV2(int $limit = 20)
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->execute();
    }
}
