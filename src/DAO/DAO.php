<?php

namespace Miniquiz\DAO;

use Doctrine\DBAL\Connection;

abstract class DAO {
    /**
     * Connexion à la base de données.
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructeur.
     *
     * @param \Doctrine\DBAL\Connection L 'objet de connexion à la base de données.
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }

    /**
     * Autorise l'accès à l'objet de connexion à la base de données.
     *
     * @return \Doctrine\DBAL\Connection L'objet de connexion à la base de données.
     */
    protected function getDb() {
        return $this->db;
    }

    /**
     * Construit un objet à partir d'une ligne.
     * Doit être réécris dans la classe enfant.
     *
     * @param array $row La ligne de la base de données.
     */
    protected abstract function buildDomainObject($row);
}