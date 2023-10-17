<?php

namespace App\Repository;

use App\Entity\Creneau;
use App\Entity\Formateur;
use App\Entity\ModuleFormation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Creneau>
 *
 * @method Creneau|null find($id, $lockMode = null, $lockVersion = null)
 * @method Creneau|null findOneBy(array $criteria, array $orderBy = null)
 * @method Creneau[]    findAll()
 * @method Creneau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CreneauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Creneau::class);
    }

    public function save(Creneau $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Creneau $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findCreneauxByFormateur(Formateur $formateur)
    {
        return $this->createQueryBuilder('c')
            ->where(':formateur MEMBER OF c.formateurs')
            ->setParameter('formateur', $formateur)
            ->getQuery()
            ->getResult();
    }

    public function findDemandesByFormateur(Formateur $formateur)
    {
        return $this->createQueryBuilder('c')
        ->select('c.id', 'c.dateDebut', 'c.dateFin', 'mf.nom as module', 'c.commentaire')
        ->join('c.moduleFormation', 'mf')
        ->where(':formateur = c.formateur AND c.envoye = :envoye')
        ->setParameter('formateur', $formateur)
        ->setParameter('envoye', true)
        ->getQuery()
        ->getResult();
    }

    public function setEnvoyeById(int $creneauId, bool $accepte)
{
    $creneau = $this->find($creneauId);

    if ($creneau) {
        $creneau->setEnvoye(false);
        $creneau->setAccepte($accepte);
        $this->_em->persist($creneau);
        $this->_em->flush();
    }
}

//    /**
//     * @return Creneau[] Returns an array of Creneau objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Creneau
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
