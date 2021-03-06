<?php

namespace AppBundle\Repository;

/**
 * AddressRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AddressRepository extends \Doctrine\ORM\EntityRepository
{
 const ACTIVE = 1;
 CONST DEACTIVE = 0;

    //function to return active addresses FOR ADMIN 
    public function findActiveAddresses($user){
        // echo $userId;
        // die;
        return $this->createQueryBuilder('a')
               
                    // ->setParameter('userType', self::SELLER)
                    ->andWhere('a.user = :user')
                    ->andWhere('a.status = :status')
                    ->setParameter('user', $user)
                    ->setParameter('status', self::ACTIVE)
                    ->getQuery()
                    ->getResult();
    }
     
    
    //function to return deactive addresses FOR ADMIN
    public function findDeactiveAddresses($user){
        return $this->createQueryBuilder('a')
                    ->andWhere('a.user = :user')
                    ->andwhere('a.status = :status')
                    ->setParameter('user', $user)
                    ->setParameter('status', self::DEACTIVE)
                    // ->leftJoin('a.address','as')
                    // ->setParameter('userType', self::SELLER)
                    ->getQuery()
                    ->getResult();
    }

    public function setAddressActive($addressId){

        $dm = $this->getEntityManager();
        $address = self::find($addressId);
        $address->setStatus(self::ACTIVE);
        $dm->flush();
        return;

    }

    //to get the all address of the user..
    public function findAllAddress($user){
        return $this->createQueryBuilder('a')
                    ->andWhere('a.user = :user')
                    ->setParameter('user',$user)
                    // ->leftJoin('a.user','user_id')
                    // ->setParameter('user',$user)
                    ->getQuery()
                    ->getResult();
    }
}
