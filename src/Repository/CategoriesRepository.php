<?php

namespace App\Repository;

use App\Entity\Categories;
use App\Entity\Produits;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categories>
 *
 * @method Categories|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categories|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categories[]    findAll()
 * @method Categories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categories::class);
    }

    public function save(Categories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Categories $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    public function getUnProduitCateg(int $id_categ)
//    {
//        $entityManager = $this->getEntityManager();
//        $categ = $entityManager->getRepository(Categories::class)->find($id_categ);
//
//        $articles = $categ->;
//
//        return $articles;
//    }

    public function getUnProduitCateg(int $id_categ){
        $entityManager = $this->getEntityManager();

        //BONNE FACON DE FAIRE AVEC REQUETE SQL

        // Récupérer la catégorie correspondante à l'id donné
        $categ = $entityManager->getRepository(Categories::class)->find($id_categ);

        // Vérifier si la catégorie existe
        if (!$categ) {
            throw $this->createNotFoundException('La catégorie n\'existe pas');
        }

        // Récupérer la collection d'articles associés à cette catégorie
        $produits = $categ->getProduits();

        // Initialiser un tableau pour stocker les informations des articles
        $articlesData = [];

        // Boucler sur la collection d'articles pour extraire les informations souhaitées
        foreach ($produits as $produit) {
            $produitsData[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNomProduit(),
                'Legende' => $produit->getLegende(),
                'description' => $produit->getDescription(),
                'image' => $produit->getImage(),
                'prix' => $produit->getPrix(),
                'categorie' => $produit->getIdCateg()->getProduits()
            ];
        }

        return $produitsData;
    }







//    /**
//     * @return Categories[] Returns an array of Categories objects
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

//    public function findOneBySomeField($value): ?Categories
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
