Database syncing - README.txt

WHENEVER YOU WANT TO UPDATE THE DB STRUCTURE
(And are ready to push your commits to Bitbucket)

1. Make the changes (add tables, add/edit indexes, change columns, etc.)

2. Put any updates you do into a .sql file as SQL statements (DB management programs such as Sequel Pro have a console where you can copy the SQL statements of the updates you made).

3. Insert a row into the `schema_version`. Put the insert statement at the bottom of the SQL file.

Column values:

migration_code -> the name of the sql file (i.e., john-002)
extra_notes -> notes about the changes you made, similar to commit messages

Here is an example insert statement:

INSERT INTO `schema_version` (`migration_code`, `extra_notes`) 
VALUES (
  'john-002', 
  'Updated table X. Changed name of column Y.'
);

4. Save the SQL file in the sql directory. Name the file a number greater than your newest one. For example: john-002.sql

5. Commit.

6. Push your changes to the Alphasquare repo on Bitbucket.


- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


UPDATING YOUR LOCAL COPY OF THE DATABASE

1. Pull from Bitbucket using git pull.

2. Run the new SQL files (look in the `schema_version` table on your local machine to determine the latest SQL file you have). You can run them in either a desktop database management application or phpMyAdmin.

That's it! You should now have the newest database structure.

The `schema_version` table will be updated because each SQL file you run will have an insert statement to insert a row into it (assuming everybody followed the instructions).