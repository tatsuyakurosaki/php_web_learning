select 
    id, 
    name, 
    hashed_password 
from 
    accounts
where
    name = :name
