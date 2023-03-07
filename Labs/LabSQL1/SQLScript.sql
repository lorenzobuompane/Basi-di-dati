#1
SELECT *
FROM deliverers

#2
SELECT DISTINCT companyid
FROM companydel

#3
SELECT name, delivererid
FROM deliverers
WHERE name LIKE 'B%'

#4
SELECT name, sex, delivererid
FROM deliverers
WHERE phoneno<>8467 OR phoneno IS NULL

#5
SELECT DISTINCT d.name, d.town
FROM penalties p, deliverers d
WHERE p.delivererid=d.delivererid

#6
SELECT DISTINCT d.name, d.initials
FROM deliverers d, penalties p, companyid c
WHERE p.delivererid=d.delivererid
AND p.delivererid=c.delivererid
AND p.data>TO_DATE('08/12/1980', 'DD/MM/YYYY')
ORDER BY d.name

#7
SELECT cd.companyid, d.delivererid
FROM deliverers d, companydel cd
WHERE d.delivererid=cd.delivererid
AND d.town='Stratford'
AND cd.numcollections>=2 
AND cd.numdeliveries>=1

#8
SELECT DISTINCT d.delivererid
FROM deliverers d, companydel cd, companies c
WHERE d.delivererid=cd.delivererid
AND c.companyid=cd.companyid
AND c.mandate='first'
AND cd.numdeliveries>=1
AND d.year_of_birth>1962
ORDER BY d.delivererid DESC

#9
SELECT DISTINCT d.name
FROM deliverers d, companydel cd
WHERE d.delivererid=cd.delivererid
AND (d.town='Stratford' OR d.town='Inglewood')
GROUP BY d.delivererid, d.name
HAVING COUNT(*)>=2

#10
SELECT p.delivererid, SUM(p.amount)
FROM deliverers d, penalties p
WHERE d.delivererid=p.delivererid
AND d.town='Inglewood'
GROUP BY p.delivererid
HAVING COUNT(*)>=2

#11
SELECT d.name, MIN(p.amount)
FROM deliverers d, penalties p
WHERE d.delivererid=p.delivererid
GROUP BY d.delivererid, d.name
HAVING COUNT(*)>=2 
AND COUNT(*)<=4

#12
SELECT SUM(cd.numdeliveries), SUM(cd.numcollections)
FROM companydel cd, deliverers d
WHERE cd.delivererid=d.delivererid
AND d.town<>'Stratford'
AND d.name LIKE 'B%'

SEQUENCE OF COMMANDS
SELECT *
FROM deliverers;

SELECT DISTINCT companyid
FROM companydel;

SELECT name, delivererid
FROM deliverers
WHERE name LIKE 'B%';

SELECT name, sex, delivererid
FROM deliverers
WHERE phoneno<>8467 OR phoneno IS NULL;

SELECT DISTINCT d.name, d.town
FROM penalties p, deliverers d
WHERE p.delivererid=d.delivererid;

SELECT DISTINCT d.name, d.initials
FROM deliverers d, penalties p, companyid c
WHERE p.delivererid=d.delivererid
AND p.delivererid=c.delivererid
AND p.data>TO_DATE('08/12/1980', 'DD/MM/YYYY')
ORDER BY d.name;

SELECT cd.companyid, d.delivererid
FROM deliverers d, companydel cd
WHERE d.delivererid=cd.delivererid
AND d.town='Stratford'
AND cd.numcollections>=2 
AND cd.numdeliveries>=1;

SELECT DISTINCT d.delivererid
FROM deliverers d, companydel cd, companies c
WHERE d.delivererid=cd.delivererid
AND c.companyid=cd.companyid
AND c.mandate='first'
AND cd.numdeliveries>=1
AND d.year_of_birth>1962
ORDER BY d.delivererid DESC;

SELECT DISTINCT d.name
FROM deliverers d, companydel cd
WHERE d.delivererid=cd.delivererid
AND (d.town='Stratford' OR d.town='Inglewood')
GROUP BY d.delivererid, d.name
HAVING COUNT(*)>=2;

SELECT p.delivererid, SUM(p.amount)
FROM deliverers d, penalties p
WHERE d.delivererid=p.delivererid
AND d.town='Inglewood'
GROUP BY p.delivererid
HAVING COUNT(*)>=2;

SELECT d.name, MIN(p.amount)
FROM deliverers d, penalties p
WHERE d.delivererid=p.delivererid
GROUP BY d.delivererid, d.name
HAVING COUNT(*)>=2 
AND COUNT(*)<=4;

SELECT SUM(cd.numdeliveries), SUM(cd.numcollections)
FROM companydel cd, deliverers d
WHERE cd.delivererid=d.delivererid
AND d.town<>'Stratford'
AND d.name LIKE 'B%';