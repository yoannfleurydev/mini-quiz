<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\Answer;

class AnswerDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_answer WHERE question_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mq_answer matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_answer";
        $rows = $this->getDb()->fetchAll($sql);

        $answer = array();
        foreach($rows as $row) {
            $answer_id = $row['answer_id'];
            $answer[$answer_id] = $this->buildDomainObject($row);
        }
        return $answer;
    }

    public function saveAnswer($answer_content) {
        $answerData = array (
            'answer_content' => $answer_content
        );


        $this->getDb()->insert("mq_answer", $answerData);
        return $this->getDb()->lastInsertId();
    }

    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row)
    {
        $answer = new Answer();
        $answer->setAnswerId($row['answer_id']);
        $answer->setAnswerContent($row['question_text']);
        return $answer;
    }
}