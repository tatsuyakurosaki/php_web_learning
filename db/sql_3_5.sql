select 
    co.id course_id, 
    co.title course_title, 
    se.id section_id, 
    se.title section_title, 
    se.no section_no, 
    hi.created_at 
from 
    histories hi 
    inner join sections se on hi.section_id = se.id 
    inner join courses co on se.course_id = co.id 
where 
    hi.account_id = :account_id
order by
    hi.created_at desc