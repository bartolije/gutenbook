<?php

namespace BackBundle\Repository;

use BackBundle\Entity\Category;
use BackBundle\Entity\Theme;
use Doctrine\ORM\EntityRepository;

/**
 * BookRepository
 */
class BookRepository extends EntityRepository
{
    public function searchBooks($title, $category, $theme)
    {
        $query = $this->createQueryBuilder('b')
            ->where('b.title LIKE :title')
            ->setParameter('title', '%'.$title.'%');

            if($category instanceof Category)
            {
                $query->andWhere('b.categories = :category')
                ->setParameter('category', $category);
            }

            if($theme instanceof Theme)
            {
                $query->andWhere('b.themes = :theme')
                ->setParameter('theme', $theme);
            }

        return $query->getQuery()->getResult();
    }
}
