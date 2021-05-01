<?php


namespace App\database\manager;


use App\database\EntityManager;
use App\database\PreparedQuery;
use App\database\Query;

class SecteurActiviteManager extends Manager
{

    /**
     * @inheritDoc
     */
    public function find(int $id): ?string
    {
        $result = (new PreparedQuery('MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ') WHERE id(s)=$id RETURN s'))
            ->setInteger('id', $id)
            ->run()
            ->getOneOrNullResult();

        return $result == null ? null : $result['nom'];
    }

    /**
     * @inheritDoc
     */
    public function findOneBy(array $filters): ?string
    {
        $query = 'MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ') WHERE ';
        foreach ($filters as $filter)
            $query .= $filter . '=' . $filters[$filter];
        $query .= ' RETURN s';

        $result = (new Query($query))
            ->run()
            ->getOneOrNullResult();

        return $result == null ? null : $result['nom'];
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return (new Query('MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ') RETURN s'))
            ->run()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findBy(array $filters): array
    {
        $query = 'MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ') WHERE ';
        foreach ($filters as $filter)
            $query .= $filter . '=' . $filters[$filter];
        $query .= ' RETURN s';

        return (new Query($query))
            ->run()
            ->getResult();
    }

    /**
     * @param string $nom
     */
    public function create(string $nom)
    {
        (new PreparedQuery('CREATE (:' . EntityManager::SECTEUR_ACTIVITE . ' {nom:$nom})'))
            ->setString('nom', $nom)
            ->run();
    }

    /**
     * @param int $id
     * @param string $nom
     */
    public function update(int $id, string $nom)
    {
        (new PreparedQuery('MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ') WHERE id(s)=$id SET s.nom=$nom'))
            ->setInteger('id', $id)
            ->setString('nom', $nom)
            ->run();
    }

    /**
     * @param int $id
     */
    public function remove(int $id)
    {
        (new PreparedQuery('MATCH (s:' . EntityManager::SECTEUR_ACTIVITE . ')-[r]-() WHERE id(s)=$id DELETE r,s'))
            ->setInteger('id', $id)
            ->run();
    }

    /**
     * @return string[]
     */
    public function findAllNames(): array
    {
        $res = [];
        $results = $this->findAll();

        foreach ($results as $result) {
            $res[] = $result['s']['nom'];
        }

        return $res;
    }
}