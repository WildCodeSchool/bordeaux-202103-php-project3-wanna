<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findAllAdmin()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->where('u.roles LIKE :isAdmin')
            ->setParameter('isAdmin', '%ROLE_ADMIN%')
            ->getQuery();
        return $queryBuilder->getResult();
    }


    /**
     * @return User[] Returns an array of User objects
     */
    public function AllUsersWithDetails()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->leftJoin('u.organization', 'o')
            ->leftJoin('u.country', 'c')
            ->leftJoin('u.languages','l')
            ->leftJoin('u.skills', 's')
            ->leftJoin('u.avatar', 'a')
            ->select('u', 'l','c','s','a','o')
            ->where('o.name IS NULL')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function AllOrganizationsWithDetails()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->leftJoin('u.organization', 'o')
            ->leftJoin('u.country', 'c')
            ->leftJoin('u.languages','l')
            ->leftJoin('u.skills', 's')
            ->leftJoin('u.avatar', 'a')
            ->select('u', 'l','c','s','a','o')
            ->where('o.name IS NOT NULL')
            ->getQuery();
        return $queryBuilder->getResult();
    }


    /**
     * @return User[] Returns an array of User objects
     */
    public function findUniqueUserSkills()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->join('u.skills', 's')
            ->select('s.name')
            ->distinct(true)
            ->getQuery();
        return $queryBuilder->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findUniqueUserLanguages()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->join('u.languages', 'l')
            ->select('l.name')
            ->distinct(true)
            ->getQuery();
        return $queryBuilder->getResult();
    }

    /**
     * @return User[] Returns an array of User objects
     */
    public function findUniqueUserCountries()
    {
        $queryBuilder = $this
            ->createQueryBuilder('u')
            ->join('u.country', 'c')
            ->select('c.name')
            ->distinct(true)
            ->getQuery();
        return $queryBuilder->getResult();
    }
}
