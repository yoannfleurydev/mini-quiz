<?php

namespace Miniquiz\DAO;

use Miniquiz\Domain\User;

class UserDAO extends DAO
{
    /**
     * Returns a user matching the supplied id.
     *
     * @param integer $id The user id.
     * @return \Miniquiz\Domain\User return a user if matching user is found
     * @throws \Exception throws an exception if no matching user is found
     */
    public function find($id) {
        $sql = "SELECT * FROM mq_user WHERE user_id=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new \Exception("No mq_user matching id " . $id);
    }

    public function findAll() {
        $sql = "SELECT * FROM mq_user";
        $rows = $this->getDb()->fetchAll($sql);

        $users = array();
        foreach($rows as $row) {
            $user_id = $row['user_id'];
            $users[$user_id] = $this->buildDomainObject($row);
        }
        return $users;
    }

    public function deleteId($id) {
        $this->getDb()->delete('mq_user', array('user_id' => $id));
    }

    public function findByUserLogin($user_login)
    {
        $sql = "select * from mq_user where user_login=?";
        $row = $this->getDb()->fetchAssoc($sql, array($user_login));

        if ($row)
            return $this->buildDomainObject($row);
        else
            throw new UsernameNotFoundException(sprintf('User "%s" not found.', $user_login));
    }

    public function verifLogs($user_login, $password) {
        $sql = "SELECT * FROM mq_user WHERE user_login=?";
        $row = $this->getDb()->fetchAssoc($sql, array(htmlspecialchars($user_login)));

        return password_verify($password, $row['user_password']);
    }

    public function usernameIsFree($username) {
        $login = htmlspecialchars($username);
        $sql = "SELECT * FROM mq_user WHERE user_login=?";
        $row = $this->getDb()->fetchAssoc($sql, array($login));

        if ($row == NULL) {
            return true;
        } else {
            return false;
        }
    }

    public function setUser($username, $password) {
        $login = htmlspecialchars($username);
        $options = array('cost' => 11);
        $pass = password_hash($password, PASSWORD_BCRYPT, $options);


        $userData = array(
            'user_login' => $login,
            'user_password' => $pass,
            // TODO en dur dans le code, mais peut être serait-il intéressant de faire une requête sur la base de
            // données pour avoir par défaut l'id qui correspond à un USER.
            'user_access_id' => 2
        );

        $this->getDb()->insert("mq_user", $userData);
    }

    public function updatePassword($user_password, $user_id) {
        $pass = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 11));

        $this->getDb()->update("mq_user", array('user_password' => $pass), array('user_id' => $user_id));
    }

    /**
     * Crée un objet \Miniquiz\Domain\User en fonction
     * des lignes dan la base de données.
     *
     * @param array $row La ligne contenant les données du User.
     * @return \Miniquiz\Domain\User
     */
    protected function buildDomainObject($row) {
        $user = new User();
        $user->setUserId($row['user_id']);
        $user->setUserLogin($row['user_login']);
        $user->setUserPassword($row['user_password']);
        $user->setUserAccessId($row['user_access_id']);
        return $user;
    }
}