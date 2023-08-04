select 
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
    no
