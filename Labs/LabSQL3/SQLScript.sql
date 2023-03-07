SELECT delivererid, MIN(data), MAX(data)
FROM penalties
GROUP BY delivererid
HAVING COUNT(*)>=2;


SELECT p1.delivererid, p1.data, p1.amount
FROM penalties p1
WHERE p1.data=(SELECT MAX(p2.data)
    FROM penalties p2
    WHERE p1.delivererid=p2.delivererid
    );


SELECT companyid
FROM companydel
GROUP BY companyid
HAVING COUNT(*)>(
            SELECT 0.30*COUNT(*)
            FROM deliverers
            );