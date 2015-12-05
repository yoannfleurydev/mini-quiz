<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\QuizSave;

class QuizSaveDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_quizsave WHERE quiz_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mq_quiz matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_quizsave";
        $rows = $this->getDb()->fetchAll($sql);

        $quiz = array();
        foreach($rows as $row) {
            $quiz_id = $row['quiz_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }
        return $quiz;
    }

    public function findByUser($idUser) {
        $sql = "SELECT * FROM mq_quizsave WHERE quiz_user_id=?";
        $rows = $this->getDb()->fetchAll($sql, array($idUser));

        $quiz = array();
        foreach($rows as $row) {
            $quiz_id = $row['quiz_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }
        return $quiz;
    }

    public function saveQuiz($quiz_id, $user_id, $quiz_save) {
        $quiz_save_content = json_encode($quiz_save);
        $quizData = array (
            'quiz_id' => $quiz_id,
            'user_id' => $user_id,
            'quiz_save_content' => $quiz_save_content
        );


        $this->getDb()->insert("mq_quizsave", $quizData);
        return $this->getDb()->lastInsertId();
    }

    public function updateQuiz($quiz_id, $user_id, $quiz_save) {
        $quiz_save_content = json_encode($quiz_save);
        $quizData = array (
            'quiz_save_content' => $quiz_save_content
        );

        $this->getDb()->update("mq_quizsave", $quizData, array('quiz_id' => $quiz_id, 'user_id' => $user_id));
    }

    public function deleteId($quiz_id, $user_id) {
        $this->getDb()->delete('mq_quizsave', array('quiz_id' => $quiz_id, 'user_id' => $user_id));
    }

    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row)
    {
        $quiz = new QuizSave();
        $quiz->setQuizSaveId($row['quiz_save_id']);
        $quiz->setQuizId($row['quiz_id']);
        $quiz->setUserId($row['user_id']);
        $json_object = json_decode($row['quiz_save_content']);
        $quiz->setQuestions($json_object['questions']);
        $quiz->setAnswers($json_object['answers']);
        return $quiz;
    }
}