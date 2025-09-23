-- Display the department names and the names of the city  they are in.
SELECT dpt.department_name, loc.city
FROM departments as dpt LEFT JOIN locations as loc
ON dpt.location_id=loc.location_id;
-- Display the full data about all employees along with the name of the managers (supervisors ) they report to.
SELECT emp.hire_date as emp_date , mgrs.first_name as managerName
FROM employees as emp LEFT OUTER JOIN employees as mgrs
ON  emp.manager_id= mgrs.employee_id 
ORDER BY mgrs.first_name;
-- 3- Display the department ID, department name, manager ID, and the name of the manager.
SELECT dpt.department_id , dpt.department_name, dpt.manager_id, mgrs.first_name
FROM departments as dpt LEFT OUTER JOIN employees as mgrs
ON dpt.manager_id=mgrs.employee_id;
/* 4- Display (Using Union Function)
 a. The last name and the job id of the employees works in dept 30
 b. The last name and the job id of the employees works in dept 60*/
 SELECT last_name, job_id
 FROM employees
 WHERE department_id=30
 UNION
 SELECT last_name,job_id
 FROM employees
 WHERE
 department_id=60;
 -- 5- Display the ID, name, and city of the departments in Roma or Seattle  city.
 SELECT dpt.department_id, dpt.department_name, loc.city
 FROM departments as dpt JOIN locations as loc 
 ON dpt.location_id=loc.location_id
 WHERE loc.city IN ('Roma', 'Seattle');
 -- 6- Display the full data of the departments with names that start with the letter "a".
 SELECT * 
 FROM departments
 WHERE department_name LIKE('a%');
 --  7- Display all the employees in department 30 whose salary is between 7000 to 15000.
 SELECT * 
 FROM employees
 WHERE department_id=30 AND salary BETWEEN 7000 AND 15000;
 -- 8- Find the names of the employees who directly report to Steven King.
 SELECT concat(emp.first_name,' ', emp.last_name) as FUllName
 FROM employees as emp, employees as mgr
 WHERE emp.manager_id=mgr.employee_id AND concat(mgr.first_name,' ',mgr.last_name)='Steven King';
 --  9- For each department, list the department name and the total salary (for all employees) spent on that department.
 SELECT dpt.department_name ,  sum(coalesce(emp.salary,0))
 FROM departments as dpt LEFT OUTER JOIN employees as emp
 ON dpt.department_id=emp.department_id
 GROUP BY dpt.department_name;
 -- 10- Retrieve the names of all employees and the names of the departments they are working in, sorted by the department name.
  SELECT  CONCAT(emp.first_name, ' ', emp.last_name) as emp_name ,dpt.department_name
 FROM departments as dpt INNER JOIN employees as emp
 ON dpt.department_id=emp.department_id
 ORDER BY dpt.department_name;
 -- 11- Display the data of the department which has the smallest employee ID over all employees' ID.
 SELECT *
 FROM departments
 WHERE department_id= (SELECT department_id FROM employees WHERE employee_id=(SELECT MIN(employee_id) FROM employees));
 --  12- For each department, retrieve the department name and the maximum, minimum, and average salary of its employees.
  SELECT dpt.department_name ,  MAX(coalesce(emp.salary,0)) as maximun ,  MIN(coalesce(emp.salary,0)) as Minimum, AVG(coalesce(emp.salary,0)) as Average
 FROM departments as dpt LEFT OUTER JOIN employees as emp
 ON dpt.department_id=emp.department_id
 GROUP BY dpt.department_name;
 --  13- For each department, if its average salary is less than the average salary of all employees, display its number, name, and number of its employees.
SELECT dpt.department_id, dpt.department_name, COUNT(emp.employee_id), avg(salary)
FROM departments as dpt JOIN employees as emp
ON dpt.department_id=emp.department_id
GROUP BY dpt.department_name
HAVING AVG(emp.salary) < (SELECT AVG(salary) FROM employees);
--  14- Retrieve a list of employees and the departments they are working in, ordered by department and within each department, ordered alphabetically by last name, first name.
SELECT dpt.department_name, emp.first_name,emp.last_name
FROM employees as emp JOIN departments as dpt
ON emp.department_id=dpt.department_id
ORDER BY dpt.department_name ASC, emp.first_name ASC,emp.last_name ASC;