<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\Question;

class QuestionDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_question WHERE question_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mq_question matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_question";
        $rows = $this->getDb()->fetchAll($sql);

        $quiz = array();
        foreach($rows as $row) {
            $question_id = $row['question_id'];
            $question[$question_id] = $this->buildDomainObject($row);
        }
        return $quiz;
    }

    public function saveQuiz($question_text, $question_good_answer) {
        $questionData = array (
            'question_text' => $question_text,
            'question_good_answer' => $question_good_answer
        );


        $this->getDb()->insert("mq_question", $questionData);
        return $this->getDb()->lastInsertId();
    }

    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row)
    {
        $question = new Question();
        $question->setQuestionId($row['question_id']);
        $question->setQuestionText($row['question_text']);
        $question->setQuestionGoodAnswer($row['question_good_answer']);
        return $question;
    }
}