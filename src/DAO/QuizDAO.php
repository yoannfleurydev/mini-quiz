<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\Quiz;

class QuizDAO extends DAO {
    public function find($id) {
        $sql = "SELECT * FROM mq_quiz WHERE quiz_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mq_quiz matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_quiz";
        $rows = $this->getDb()->fetchAll($sql);

        $quiz = array();
        foreach($rows as $row) {
            $quiz_id = $row['quiz_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }
        return $quiz;
    }

    public function titleIsFree($title) {
        $quiz_title = htmlspecialchars($title);
        $sql = "SELECT * FROM mq_quiz WHERE quiz_title=?";
        $row = $this->getDb()->fetchAssoc($sql, array($quiz_title));

        if ($row == NULL) {
            return true;
        } else {
            return false;
        }
    }
    public function findByAuthor($idUser) {
        $sql = "SELECT * FROM mq_quiz WHERE quiz_user_id=?";
        $rows = $this->getDb()->fetchAll($sql, array($idUser));

        $quiz = array();
        foreach($rows as $row) {
            $quiz_id = $row['quiz_id'];
            $quiz[$quiz_id] = $this->buildDomainObject($row);
        }
        return $quiz;
    }

    public function saveQuiz($title, $description, $userId) {
        $quizData = array (
            'quiz_title' => $title,
            'quiz_description' => $description,
            'quiz_user_id' => $userId
        );


        $this->getDb()->insert("mq_quiz", $quizData);
        return $this->getDb()->lastInsertId();
    }

    public function updateQuiz($title, $description, $QuizId) {
        $quizData = array (
            'quiz_title' => $title,
            'quiz_description' => $description
        );


        $this->getDb()->update("mq_quiz", $quizData, array('quiz_id' => $QuizId));
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
        $quiz->setQuizDescription($row['quiz_description']);
        $quiz->setQuizUserId($row['quiz_user_id']);
        return $quiz;
    }
}