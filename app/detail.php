<?php
require_once("../libs/functions.php");
require_once("../libs/CourseDAO.php");
require_once("../libs/SectionDAO.php");

$course_id = (string)filter_input(INPUT_GET, "course_id");
if ($course_id === "") {
    error_log("Valitation Error! : Invalid id");
    header("Location: error.php");
    exit();
}
if (filter_var($course_id, FILTER_VALIDATE_INT) === false) {
    error_log("Validation Error! : Invalid course_id");
    header("Location: error.php");
    exit();
}

$section_id = (string)filter_input(INPUT_GET, "section_id");
if ($section_id !== "" && filter_var($section_id, FILTER_VALIDATE_INT) === false) {
    error_log("Validation Error! : Invalid section_id");
    header("Location: error.php");
    exit();                                                        
}

try {
    $pdo = new_PDO();
    
    $course_dao = new CourseDAO($pdo);
    $course = $course_dao->selectById($course_id);
    if ($course === false) {
        error_log("Invalid course id. -> {$course_id}");
        header("Location: error.php");
        exit();
    }
    
    $section_dao = new SectionDAO($pdo);
    $account_id = get_account_id();
    if ($account_id !== false){
        $sections = $section_dao->selectByCourseIdAndAccountId($course_id, $account_id);
    } else {
        $sections = $section_dao->selectByCourseId($course_id);
    }
    if (count($sections) === 0) {
        error_log("Invalid sections. -> {$course_id}");
        header("Location: error.php");
        exit();
    }

    $current_section = $sections[0];
    foreach ($sections as $section) {
        if ((int)$section['id'] === (int)$section_id) {
            $current_section = $section;
            break;
        }
    }

    if (is_sign_in()) {
        $csrf_token = generate_csrf_token();
    }

    require("../views/detail_view.php");

} catch (PDOException $e) {
    error_log($e->getMessage());
    header("Location: error.php");
}
