<?php

namespace Miniquiz\Domain;

class Answer {
    private $answer_id;
    private $answer_content;

    /**
     * @return mixed
     */
    public function getAnswerId()
    {
        return $this->answer_id;
    }

    /**
     * @param mixed $answer_id
     */
    public function setAnswerId($answer_id)
    {
        $this->answer_id = $answer_id;
    }

    /**
     * @return mixed
     */
    public function getAnswerContent()
    {
        return $this->answer_content;
    }

    /**
     * @param mixed $answer_content
     */
    public function setAnswerContent($answer_content)
    {
        $this->answer_content = $answer_content;
    }



}