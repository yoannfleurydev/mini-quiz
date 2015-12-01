<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\Answer;

class AnswerDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_answer WHERE answer_id=?";
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


    public function findByIdQuestion($idQuestion) {
        $sql = "SELECT * FROM question_answer WHERE question_id=?";
        $rows = $this->getDb()->fetchAll($sql, array($idQuestion));

        $answers = array();
        foreach ($rows as $row) {
            $sql = "SELECT * FROM mq_answer WHERE answer_id=?";
            $lines = $this->getDb()->fetchAll($sql, array($row['answer_id']));
            foreach ($lines as $line) {
                $id_answer = $line['answer_id'];
                $answers[$id_answer] = $this->buildDomainObject($line);
            }
        }


        if ($rows)
            return $answers;
    }

    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row)
    {
        $answer = new Answer();
        $answer->setAnswerId($row['answer_id']);
        $answer->setAnswerContent($row['answer_content']);
        return $answer;
    }
}