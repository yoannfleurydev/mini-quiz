<?php

namespace DAO;


use Domain\Access;
use Miniquiz\DAO\DAO;

class AccessDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_access WHERE access_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No user matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_access";
        $rows = $this->getDb()->fetchAll($sql);

        $accesses = array();
        foreach ($rows as $row) {
            $access_id = $row['access_id'];
            $accesses[$access_id] = $this->buildDomainObject($row);
        }

        return $accesses;
    }

    /**
     * Construit un objet à partir d'une ligne.
     * Doit être réécris dans la classe enfant.
     *
     * @param array $row La ligne de la base de données.
     * @return access
     */
    protected function buildDomainObject($row) {
        $user = new Access();
        $user->setAccessId($row['access_id']);
        $user->setAccessKey($row['access_key']);
        $user->setAccessName($row['access_name']);

        return $user;
    }
}