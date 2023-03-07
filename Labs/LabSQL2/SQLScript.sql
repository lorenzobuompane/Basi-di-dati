SELECT d.delivererid, d.name, d.initials
FROM deliverers d
WHERE delivererid NOT IN (
    SELECT p.delivererid
    FROM penalties p
    )
ORDER BY d.delivererid;


SELECT p1.delivererid
FROM penalties p1
WHERE p1.delivererid IN (
    SELECT p2.delivererid
    FROM penalties p2
    WHERE p2.amount=30
    )
AND p1.amount=25;


SELECT d.delivererid, d.name
FROM deliverers d
WHERE d.delivererid IN (
    SELECT p.delivererid
    FROM penalties p
    GROUP BY p.delivererid, p.data
    HAVING COUNT(*)>=2
    );


SELECT DISTINCT cd.delivererid
FROM companydel cd
GROUP BY cd.delivererid 
HAVING COUNT(*)=(
    SELECT COUNT(*)
    FROM companies
    );


SELECT delivererid
FROM companydel
WHERE companyid IN (
    SELECT companyid
    FROM companydel
    WHERE delivererid=57 
    AND (numcollections>0 OR numdeliveries>0)
    )
AND delivererid<>57;


SELECT d.delivererid, d.name
FROM deliverers d, penalties p1
WHERE d.delivererid=p1.delivererid
    AND p1.data>=TO_DATE('01/01/1980', 'DD/MM/YYYY')
    AND p1.data<=TO_DATE('31/12/1980', 'DD/MM/YYYY')
GROUP BY d.delivererid, d.name
HAVING COUNT(*)>(SELECT COUNT(*)
    FROM penalties p2
    WHERE d.delivererid=p2.delivererid
        AND p2.data>=TO_DATE('01/01/1981', 'DD/MM/YYYY')
        AND p2.data<=TO_DATE('31/12/1981', 'DD/MM/YYYY'));


SELECT delivererid
FROM penalties
GROUP BY delivererid
HAVING COUNT(*)=(
    SELECT MAX(NumPenalties)
    FROM (SELECT delivererid, COUNT(*) AS NumPenalties
        FROM penalties
        GROUP BY delivererid) TOTMULTEDELIVERERS
        );
		

SELECT delivererid
FROM companydel
WHERE delivererid<>57
AND companyid IN (
    SELECT companyid
    FROM companydel
    WHERE delivererid=57)
GROUP BY delivererid
HAVING COUNT(*)=(SELECT COUNT(*)
    FROM companydel
    WHERE delivererid=57);


SELECT DISTINCT delivererid
FROM companydel
WHERE delivererid<> 57
AND delivererid NOT IN (
    SELECT delivererid
    FROM companydel 
    WHERE companyid NOT IN (
        SELECT companyid
        FROM companydel
        WHERE delivererid=57
        )
    );


SELECT DISTINCT delivererid
FROM companydel
WHERE delivererid<> 57
AND delivererid NOT IN (
    SELECT delivererid
    FROM companydel 
    WHERE companyid NOT IN (
        SELECT companyid
        FROM companydel
        WHERE delivererid=57
        )
    )
GROUP BY delivererid
HAVING COUNT(*)=(SELECT COUNT(*)
    FROM companydel
    WHERE delivererid=57);