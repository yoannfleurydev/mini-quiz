<?php

namespace Miniquiz\Domain;

class User {
    /**
     * User id
     *
     * @var integer L'identifiant numérique unique de l'utilisateur
     */
    private $userId;

    /**
     * User name
     *
     * @var string L'identifiant pseudonyme unique de l'utilisateur
     */
    private $userLogin;

    /**
     * User password.
     *
     * @var string Le mot de passe, haché, de l'utilisateur
     */
    private $userPassword;

    /**
     * User access identifier
     *
     * @var integer L'identifiant numérique unique déterminant le type d'accès de l'utilisateur
     */
    private $userAccessId;


    /**
     * Getter de l'identifiant numérique unique de l'utilisateur
     *
     * @return int L'identifiant numérique unique de l'utilisateur
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Setter de l'attribut userId
     *
     * @param $userId L'identifiant numérique unique de l'utilisateur
     */
    public function setUserId($userId) {
        $this->userId = $userId;
    }

    /**
     * Getter de l'identifiant pseudonyme unique de l'utilisateur
     *
     * @return string L'identifiant pseudonyme unique de l'utilisateur
     */
    public function getUserLogin() {
        return $this->userLogin;
    }

    /**
     * Setter de l'identifiant pseudonyme unique de l'utilisateur
     *
     * @param $userLogin L'identifiant pseudonyme unique de l'utilisateur
     */
    public function setUserLogin($userLogin) {
        $this->userLogin = $userLogin;
    }

    /**
     * Getter du mot de passe haché de l'utilisateur
     *
     * @return string Le mot de passe haché de l'utilisateur
     */
    public function getUserPassword() {
        return $this->userPassword;
    }

    /**
     * Setter du mot de passe haché de l'utilisateur
     *
     * @param $userPassword Le mot de passe haché de l'utilisateur
     */
    public function setUserPassword($userPassword) {
        $this->userPassword = $userPassword;
    }

    /**
     * Getter de l'identifiant numérique unique déterminant le type d'accès de l'utilisateur
     *
     * @return int
     */
    public function getUserAccessId() {
        return $this->userAccessId;
    }

    /**
     * Setter de l'identifiant numérique unique déterminant le type d'accès de l'utilisateur
     *
     * @param int $userAccessId
     */
    public function setUserAccessId($userAccessId) {
        $this->userAccessId = $userAccessId;
    }
}