<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\QuizSave;

class QuizSaveDAO extends DAO {
    public function find($id, $idUser) {
        $sql = "SELECT * FROM mq_quizsave WHERE quiz_id=? AND user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id, $idUser));

        if ($row) return $this->buildDomainObject($row); else
            return null;
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_quizsave";
        $rows = $this->getDb()->fetchAll($sql);

        $quiz = array();
        foreach ($rows as $row) {
            $quiz_id = $row['quiz_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }

        return $quiz;
    }

    public function findByUser($idUser) {
        $sql = "SELECT * FROM mq_quizsave WHERE user_id=?";
        $rows = $this->getDb()->fetchAll($sql, array($idUser));

        $quizsave = array();
        foreach ($rows as $row) {
            $quizsave_id = $row['quiz_id'];
            $quizsave[$quizsave_id] = $this->buildDomainObject($row);
        }

        return $quizsave;
    }

    public function findByQuiz($idQuiz) {
        $sql = "SELECT * FROM mq_quizsave WHERE quiz_id=?";
        $rows = $this->getDb()->fetchAll($sql, array($idQuiz));

        $quizsave = array();
        foreach ($rows as $row) {
            $quizsave_id = $row['quiz_id'];
            $quizsave[$quizsave_id] = $this->buildDomainObject($row);
        }

        return $quizsave;
    }

    public function addSaveQuiz($quiz_id, $user_id, $quiz_save) {
        $quiz_save_content = json_encode($quiz_save);
        $quizData = array('quiz_id' => $quiz_id, 'user_id' => $user_id, 'quiz_save_content' => $quiz_save_content);

        $this->getDb()->insert("mq_quizsave", $quizData);

        return $this->getDb()->lastInsertId();
    }

    public function updateSaveQuiz($quiz_id, $user_id, $quiz_save) {
        $quiz_save_content = json_encode($quiz_save);
        $quizData = array('quiz_save_content' => $quiz_save_content);

        $this->getDb()->update("mq_quizsave", $quizData, array('quiz_id' => $quiz_id, 'user_id' => $user_id));
    }

    public function deleteId($quiz_id, $user_id) {
        $this->getDb()->delete('mq_quizsave', array('quiz_id' => $quiz_id, 'user_id' => $user_id));
    }

    /**
     * @param $row La ligne de la base de données en tableau PHP
     * @return Quiz L'objet Quiz instancié
     */
    protected function buildDomainObject($row) {
        $quiz = new QuizSave();
        $quiz->setQuizSaveId($row['quiz_save_id']);
        $quiz->setQuizId($row['quiz_id']);
        $quiz->setUserId($row['user_id']);
        $json_object = json_decode($row['quiz_save_content'], true);
        $quiz->setQuestions($json_object['questions']);
        $quiz->setAnswers($json_object['answer']);

        return $quiz;
    }
}