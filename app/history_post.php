<?php

require_once("../libs/functions.php");
require_once("../libs/HistoryDAO.php");

$account_id = get_account_id();
if ($account_id === false) {
    error_log("Not signed in");
    set_message("Not signed in");
    header("Location: error.php");
    exit();
}

$csrf_token = filter_input(INPUT_POST, "csrf_token");
if (validate_csrf_token($csrf_token) === false) {
    error_log("Invalid CSRF token: ". $csrf_token);
    set_message("Invalid CSRF token");
    header("Location: error.php");
    exit();
}

$course_id = (string)filter_input(INPUT_POST, "course_id");
if ($course_id === "") {
    error_log("Valitation Error! : Invalid id");
    set_message("Valitation Error: Invalid course id");
    header("Location: error.php");
    exit();
}
if (filter_var($course_id, FILTER_VALIDATE_INT) === false) {
    error_log("Validation Error! : Invalid course_id");
    set_message("Valitation Error: Invalid course id");
    header("Location: error.php");
    exit();
}

$section_id = (string)filter_input(INPUT_POST, "section_id");
if ($section_id === "") {
    error_log("Valitation Error! : Invalid Section id");
    set_message("Valitation Error: Invalid section id");
    header("Location: error.php");
    exit();
}
if (filter_var($section_id, FILTER_VALIDATE_INT) === false) {
    error_log("Validation Error! : Invalid Section id");
    set_message("Valitation Error: Invalid section id");
    header("Location: error.php");
    exit();
}

try {
    $pdo = new_PDO();

    $history_dao = new HistoryDAO($pdo);
    $history_dao->insert($account_id, $section_id);

    set_message(MESSAGE_FINISH_SECTION);

    header("Location: detail.php?course_id=$course_id&section_id=$section_id");

} catch (PDOException $e) {
    error_log($e->getMessage());
    set_message("Failed to finish section");
    header("Location: error.php");
}