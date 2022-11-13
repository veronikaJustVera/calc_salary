DELIMITER //

DROP PROCEDURE IF EXISTS get_salary_for_report //
CREATE PROCEDURE get_salary_for_report (IN param_employee_id INT,
					                    IN param_date DATE)
sp:BEGIN

    SELECT DATE_FORMAT(param_date, "%M %Y") INTO @date;
    IF EXISTS(SELECT id from employees WHERE id = param_employee_id) THEN
        SELECT CONCAT(name , ' ', surname) FROM employees WHERE id = param_employee_id INTO @name;
        IF (EXISTS(SELECT efr.id FROM employee_film_roles efr INNER JOIN film_roles fr ON fr.id = efr.film_role_id INNER JOIN films f ON f.id = fr.film_id WHERE efr.employee_id = param_employee_id AND f.start_production_date <= param_date AND f.end_production_date >= param_date GROUP BY efr.id)) THEN
            SELECT GROUP_CONCAT(r.title SEPARATOR ', '), efr.film_role_id FROM roles r INNER JOIN film_roles fr ON fr.role_id = r.id INNER JOIN employee_film_roles efr ON efr.film_role_id = fr.id INNER JOIN films f ON f.id = fr.film_id WHERE efr.employee_id = param_employee_id AND f.start_production_date <= param_date AND f.end_production_date >= param_date GROUP BY r.id INTO @role, @film_role_id;
            SELECT IFNULL(s.month_salary, 0) FROM salaries s WHERE s.film_role_id = @film_role_id INTO @salary;
            INSERT INTO histories(film_role_id, date, salary) VALUES (@film_role_id, param_date, @salary) ON DUPLICATE KEY UPDATE salary = @salary;
            SELECT @date as date,
                @salary as salary,
                @name as name,
                @role as role;
        ELSE
            -- Employee has no work in this period
            SELECT @date as date,
                0 as salary,
                @name as name,
                'Unknown' as role;
        END IF;
    ELSE
        -- Unknown employee
        SELECT @date as date,
            0 as salary,
            'Unknown' as name,
            'Unknown' as role;
    END IF;

END //

DELIMITER ;
