<?php

namespace App\Repository;

use App\Entity\Car;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Car::class);
    }

    public function save(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Car $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get published posts thanks to Search Data value
     *
     * @param SearchData $searchData
     * @return PaginationInterface
     */
    public function findBySearch(SearchData $searchData): PaginationInterface
    {
        $data = $this->createQueryBuilder('v');
    
        if (!empty($searchData->q)) {
            $data = $data
                ->andWhere('v.name LIKE :q')
                ->setParameter('q', "%{$searchData->q}%");
        }

        if (!empty($searchData->categories)) {
            $data = $data
                ->join('v.category', 'c')
                ->andWhere('c.id IN (:category)')
                ->setParameter('category', $searchData->categories);
        }

        $data = $data
            ->getQuery()
            ->getResult();

        $cars = $this->paginatorInterface->paginate($data, $searchData->page, 10);

        return $cars;
    }
}
