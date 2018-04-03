
######################################################################################
#### https://leetcode.com/problems/department-top-three-salaries/description/ ########
######################################################################################

# my submittion optimization
SELECT Department,Employee,Salary FROM (
	SELECT sortLists.departmentName AS Department, sortLists.Name AS Employee, Salary, 
	@rn := IF(@prev = DepartmentId,IF(@prevSalary <> Salary, @rn + 1, @rn),1) AS rowNum,
	@prev := DepartmentId,
	@prevSalary := Salary FROM (SELECT employee.Id,employee.NAME,Salary,DepartmentId,Department.`Name` AS departmentName FROM employee 
	INNER JOIN Department ON Department.`Id` = employee.DepartmentId ORDER BY DepartmentId,Salary DESC,Id) AS sortLists JOIN 
	(SELECT @prev := NULL, @rn := 0,@prevSalary := 0) AS vars 
) t2 WHERE rowNum < 4 ORDER BY Department,Salary DESC
;

#My submittion 1
SELECT 
  Department.`Name` AS Department,
  t2.Name AS Employee,
  t2.Salary 
FROM
  Department 
  RIGHT JOIN 
    (SELECT 
      Id,
      NAME,
      Salary,
      DepartmentId 
    FROM
      (SELECT 
        *,
        @rn := IF(
          @prev = DepartmentId,
          IF(@prevSalary <> Salary, @rn + 1, @rn),
          1
        ) AS rowNum,
        @prev := DepartmentId,
        @prevSalary := Salary 
      FROM
        (SELECT 
          Id,
          NAME,
          Salary,
          DepartmentId 
        FROM
          employee 
        ORDER BY DepartmentId,
          Salary DESC,
          Id) AS sortLists 
        JOIN 
          (SELECT 
            @prev := NULL,
            @rn := 0,
            @prevSalary := 0) AS vars) t1 
    WHERE rowNum < 4) t2 
    ON Department.`Id` = t2.DepartmentId
;


 #offical answer
SELECT
    d.Name AS 'Department', e1.Name AS 'Employee', e1.Salary
FROM
    Employee e1
        JOIN
    Department d ON e1.DepartmentId = d.Id
WHERE
    3 > (SELECT
            COUNT(DISTINCT e2.Salary)
        FROM
            Employee e2
        WHERE
            e2.Salary > e1.Salary
                AND e1.DepartmentId = e2.DepartmentId
        )
;


#answer by 'group'
SELECT 
  d.Name AS Department,
  e.Name AS Employee,
  e.Salary 
FROM
  Employee AS e 
  LEFT JOIN 
    (SELECT 
      Salary,
      DepartmentId,
      @rank := IF(@curD = DepartmentId, @rank + 1, 1) AS Rank,
      @curD := DepartmentId 
    FROM
      (SELECT 
        Salary,
        DepartmentId 
      FROM
        Employee 
      GROUP BY DepartmentId,
        Salary 
      ORDER BY DepartmentId,
        Salary DESC) AS a,
      (SELECT 
        @rank := 1,
        @curD := NULL) vars) AS r 
    ON e.DepartmentId = r.DepartmentId 
    AND e.Salary = r.Salary 
  JOIN Department AS d 
    ON e.DepartmentId = d.Id 
WHERE r.Rank <= 3 
ORDER BY Department,
  Salary DESC
;