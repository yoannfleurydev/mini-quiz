<?php

namespace Domain;

class Access {
    private $accessId;
    private $accessKey;
    private $accessName;

    /**
     * @return mixed
     */
    public function getAccessId() {
        return $this->accessId;
    }

    /**
     * @param mixed $accessId
     */
    public function setAccessId($accessId) {
        $this->accessId = $accessId;
    }

    /**
     * @return mixed
     */
    public function getAccessKey() {
        return $this->accessKey;
    }

    /**
     * @param mixed $accessKey
     */
    public function setAccessKey($accessKey) {
        $this->accessKey = $accessKey;
    }

    /**
     * @return mixed
     */
    public function getAccessName() {
        return $this->accessName;
    }

    /**
     * @param mixed $accessName
     */
    public function setAccessName($accessName) {
        $this->accessName = $accessName;
    }
}