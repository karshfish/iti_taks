SELECT CONCAT(last_name, ', ', job_id) AS `Employee and Title`
FROM employees;
--
SELECT last_name, salary FROM employees 
WHERE salary NOT BETWEEN 1500 AND 7000;
--
SELECT last_name, salary, commission_pct  FROM employees
WHERE commission_pct IS NOT NULL 
ORDER BY salary, commission_pct;  
--
SELECT last_name, job_id, salary
FROM employees
WHERE job_id IN ('SA_REP','PU_MAN') 
AND salary IN (8000,9000,9500);
--
SELECT * FROM employees
WHERE last_name LIKE('s%');
--
SELECT * FROM employees
WHERE last_name LIKE('%e_');


-- DMLs
INSERT INTO locations (
location_id,
street_address,
postal_code,
city,
state_province,
country_id
)
VALUES(
    7700,
    '18 Hekma street',
    '77877',
    'TANTA',
    'Tanta Governorate',
    'EG');
    --
    INSERT INTO departments (
    department_id,
    department_name,
    manager_id,
    location_id)
    VALUES(
    11200,
    'Tanta',
    123,
    7700);
    --
    INSERT INTO employees(job_id, employee_id, first_name, last_name, email, phone_number, hire_date, salary, commission_pct, manager_id, department_id
    )
    VALUES(
    'AC_MGR',
    112233,
    'Fouash',
    'SOAD',
    'Fouash.SOAD.112233@gmail.com',
    '011111111',
    str_to_date('Aug-12-2025','%m,$d,%Y'),
    30000,
    null,
    101,
    11200);
    --
    DELETE FROM employees
    WHERE department_id= 11200;
    DELETE FROM departments
    WHERE location_id=7700;
    DELETE FROM locations
    WHERE location_id=7700;
