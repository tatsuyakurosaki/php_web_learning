<?php
class AccountDAO {
private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectByName () {
        $sql = 'select 
        id, 
        name, 
        hashed_password 
    from 
        accounts
    where
        name = :name
    ';
    }
}