# Steps to Run Application

1. Clone project
2. Add `db.sql` to local server (db name - "calc_salary")
3. Run `npm run production`
4. Run `php artisan serve`

---

# Software Development Exercise

You have been asked to create an application for calculating the monthly remittance due to staff who work for a film production company.

The way in which each month's pay is calculated depends on the employee's role and individual contract terms, both of which can vary for each film produced, and each employee may hold more than one role for a given film.

For example:
- An actor receives a fixed fee for appearing in a film, which is spread evenly over the expected duration of filming. They may also receive a percentage share of revenue generated, for the previous month, by one or more films they have previously appeared in.
- Production staff (e.g., lighting crew) only ever receive a fixed monthly amount.
- Senior production staff (e.g., director, producer) are always paid a monthly fee during film production (which continues after filming), plus an ongoing percentage of monthly revenue generated.
- On occasion, an actor may also be a director or producer, for example.

Please note it should be possible to retrieve historical records for any given month and/or employee, so that calculations can be checked retrospectively.

## Tasks

1. Create an entity relationship diagram to represent the database tables and fields that could be used to store this information.
2. Create a separate entity relationship diagram to represent the classes and method signatures you would use to model and serve this data.
3. Write a method that, given a year, month, and employee ID, will calculate the amount (if any) owed to that employee for that month.

Please submit your answers in a universal document format, such as PDF.
