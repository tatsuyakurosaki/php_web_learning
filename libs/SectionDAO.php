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

    public function selectByCourseIdAndAccountId($course_id, $account_id) {
        $sql = "select 
                    se.id, 
                    se.title, 
                    se.no, 
                    se.url, 
                    se.course_id, 
                    hi.created_at
                from 
                    sections se
                    left join histories hi on se.id = hi.section_id
                        and hi.account_id = :account_id
                where 
                    course_id = :course_id
                order by 
                    no";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(':course_id', $course_id, PDO::PARAM_INT);
        $ps->bindValue(':account_id', $account_id, PDO::PARAM_INT);
        $ps->execute();
        $sections = $ps->fetchAll();
        return $sections;
    }

}