<?php

namespace Miniquiz\Domain;

class Quiz {
    private $quiz_id;
    private $quiz_title;
    private $quiz_user_id;

    /**
     * @return mixed
     */
    public function getQuizId()
    {
        return $this->quiz_id;
    }

    /**
     * @param mixed $quiz_id
     */
    public function setQuizId($quiz_id)
    {
        $this->quiz_id = $quiz_id;
    }

    /**
     * @return mixed
     */
    public function getQuizTitle()
    {
        return $this->quiz_title;
    }

    /**
     * @param mixed $quiz_title
     */
    public function setQuizTitle($quiz_title)
    {
        $this->quiz_title = $quiz_title;
    }

    /**
     * @return mixed
     */
    public function getQuizUserId()
    {
        return $this->quiz_user_id;
    }

    /**
     * @param mixed $quiz_user_id
     */
    public function setQuizUserId($quiz_user_id)
    {
        $this->quiz_user_id = $quiz_user_id;
    }
}