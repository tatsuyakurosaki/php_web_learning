<!-- Sectionsテーブルへの処理を実装 -->
<!-- Courseテーブルへの処理を実装 -->
<?php

class SectionDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectByCourseId($course_id) {
        $sql = "select
                        sec.id, 
                        sec.title, 
                        sec.no, 
                        sec.url, 
                        sec.course_id 
                    from 
                        sections sec
                    where
                        sec.course_id = :course_id
                    order by
                        sec.no";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":course_id", $course_id, PDO::PARAM_INT);
        $ps->execute();
        $sections = $ps->fetchAll();
        return $sections;
    }

}