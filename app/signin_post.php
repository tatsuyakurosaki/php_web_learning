<?php
require_once('../libs/functions.php');
require_once('../libs/AccountDAO.php');

$csrf_token = filter_input(INPUT_POST, "csrf_token");
if (validate_csrf_token($csrf_token) === false) {
    error_log("Invalid CSRF token: {$csrf_token}");
    header("Location: error.php");
    exit();
}

$name = (string) filter_input(INPUT_POST, "name");
if ($name === "") {
    set_message(MESSAGE_SIGNIN_ERROR);
    header("Location: signin.php");
    exit();
}
if (mb_strlen($name) > 20) {
    set_message(MESSAGE_SIGNIN_ERROR);
    header("Location: signin.php");
    exit();
}

$password = (string) filter_input(INPUT_POST, "password");
if ($password === "") {
    set_message(MESSAGE_SIGNIN_ERROR);
    header("Location: signin.php");
    exit();
}
if (mb_strlen($password) > 20) {
    set_message(MESSAGE_SIGNIN_ERROR);
    header("Location: signin.php");
    exit();
}

try {

    $pdo = new_PDO();

    $account_dao = new AccountDAO($pdo);
    $account = $account_dao->selectByName($name);

    if ($account === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        error_log("Could not find account");
        header("Location: signin.php");
        exit();
    }
    if (password_verify($password, $account['hashed_password']) === false) {
        set_message(MESSAGE_SIGNIN_ERROR);
        error_log("Invalid password for account {$account['name']}");
        header("Location: signin.php");
        exit();
    }

    sign_in($account);

    set_message(MESSAGE_SIGNIN_SUCCESS);

    header("Location: index.php");

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}