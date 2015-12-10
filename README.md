# TaxCalculator
Example Tax Calculator


Rules :

From Rp 0 to Rp 50,000,000 the tax rate is 5%.
From Rp 50,000,000 to Rp 250,000,000 the tax rate is 15%.
From Rp 250,000,000 to Rp 500,000,000 the tax rate is 25%.
Above 500,000,000 the tax rate is 30%.

I added above rules into 2 tables in SQLite3. 

#####Rules Table 
* Contains 3 fields : id (integer), name (string) and start_at (timestamp)
* This tabel will store data which rule apply based on comparison current date and start_at field.

#####Rules_Tax Table
* Contains 4 fields : id (integer), percent (integer), max_value (integer), and rules_id (integer)
* Rules_id related to parent table "Rules". 
* This table will store some detail rules for each rule parent. For this example it will store data

| id | percent | max_value  | rules_id |
|----|---------|------------|----------|
| 2  | 5       |  50000000  | 1        |
| 3  | 15      | 250000000  | 1        |
| 4  | 25      | 500000000  | 1        |
| 5  | 30      | -1         | 1        |

* record with id = 2 will store percentage 5% for range 0 - 50.000.000, id = 3 with percentage 15% for range 50.000.000 - 250.000.000, and so on.
* max_value with '-1' as value is a flag that percentage will apple for value <strong>above previous higher value</strong> (id = 4, 50.000.000 max value). This is used because there will be no minus value used, so it just trick that the record is last rule.
