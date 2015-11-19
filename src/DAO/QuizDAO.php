<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\quiz;

class QuizDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM user WHERE quiz_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No quiz matching id " . $id);
    }


    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row)
    {
        $quiz = new Quiz();
        $quiz->setQuizId($row['quiz_id']);
        $quiz->setQuizTitle($row['quiz_title']);
        $quiz->setQuizUserId($row['quiz_user_id']);
        return $quiz;
    }
}