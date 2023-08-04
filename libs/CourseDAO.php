<!-- Courseテーブルへの処理を実装 -->
<?php

class CourseDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectAll() {
        $sql = "select
                        crs.id, 
                        crs.title course_title,
                        cat.title category_title
                    from 
                        courses crs
                    inner join
                        categories cat
                    on
                        crs.category_id = cat.id
                    order by
                        crs.id";
        $stmt = $this->pdo->query($sql);
        $courses = $stmt->fetchAll();
        return $courses;
    }

    public function selectById($course_id) {
        $sql = "select
                        crs.id, 
                        crs.title course_title,
                        cat.title category_title
                    from 
                        courses crs
                        inner join
                            categories cat
                        on
                            crs.category_id = cat.id
                    where
                        crs.id = :id";
        $ps = $this->pdo->prepare($sql);
        $ps->bindValue(":id", $course_id, PDO::PARAM_INT);
        $ps->execute();
        $course = $ps->fetch();
        return $course;
    }

}