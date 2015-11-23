<?php

namespace Miniquiz\Domain;

class Question {
    private $question_id;
    private $question_text;
    private $question_good_answer;

    /**
     * @return mixed
     */
    public function getQuestionId()
    {
        return $this->question_id;
    }

    /**
     * @param mixed $question_id
     */
    public function setQuestionId($question_id)
    {
        $this->question_id = $question_id;
    }

    /**
     * @return mixed
     */
    public function getQuestionText()
    {
        return $this->question_text;
    }

    /**
     * @param mixed $question_text
     */
    public function setQuestionText($question_text)
    {
        $this->question_text = $question_text;
    }

    /**
     * @return mixed
     */
    public function getQuestionGoodAnswer()
    {
        return $this->question_good_answer;
    }

    /**
     * @param mixed $question_good_answer
     */
    public function setQuestionGoodAnswer($question_good_answer)
    {
        $this->question_good_answer = $question_good_answer;
    }


}