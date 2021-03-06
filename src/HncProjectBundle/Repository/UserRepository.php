<?php

namespace HncProjectBundle\Repository;

use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function loadUserByEmail($email)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getHash($email)
    {
        $qb = $this->_em->createQueryBuilder('u');

        $qb ->select('u.password')
            ->from('HncProjectBundle:User', 'u')
            ->where('u.email = :email')
            ->setParameter('email', $email);

        $requete = $qb->getQuery();

        try
        {
            $result = $requete->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            $result = "NoResultException";
        }
        return $result;
    }

    public function loadUserById($id)
    {
        $qb = $this->_em->createQueryBuilder('u');

        $qb ->select('u')
            ->from('HncProjectBundle:User', 'u')
            ->where('u.id = :id')
            ->setParameter('id', $id);

        $requete = $qb->getQuery();

        try
        {
            $result = $requete->getSingleResult();
        }
        catch (\Doctrine\ORM\NoResultException $e)
        {
            $result = "NoResultException";
        }
        return $result;
    }
}
