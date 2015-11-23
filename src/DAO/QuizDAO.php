<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\quiz;

class QuizDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_quiz WHERE quiz_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No quiz matching id " . $id);
    }
    public function findAll() {
        $sql = "SELECT * FROM mq_quiz";
        $rows = $this->getDb()->fetchAll($sql);

        $quiz = array();
        foreach($rows as $row) {
            $quiz_id = $row['user_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }
        return $quiz;
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