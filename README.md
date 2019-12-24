# Backend Take Home Excersise

### Excersise Requirements

This take home exercise will test your general knowledge of PHP and design patterns. The exercise
mimics a scenerio we see often when it comes to managing and displaying statisical data. You will be
required to:

- Write a PHP script that summarizes and inserts the clicks table data into the summary table. The populated summary table
  should contain the total sum of view and action values per day, per campaign.
- The clicks table should only contain data from the current day (starting at midnight). Data outside of this date range should
  be summed up via the script above and pruned from the clicks table.
- A RESTful endpoint that does the following:
  - Accepts a POST request that will register a new row in the clicks table. Will accept a "user_id" integer value, a "created_at" date timestamp value, a "view" integer value (greater than 0), and a "action" integer value (greater than 0). Will echo out a JSON resopnse
  string depending on result. Eg output:
  ```
  "success"
  ```
  - Accepts a GET request that will echo a JSON object string that contains the total views and actions for each day as well as the total
  views and actions for all days within a given date range. Eg output:
  ```
  "['all_days' => ['views' => 10, 'actions' => 5], '2019-12-23' => ['views' => 3, 'actions' => 0], '2019-12-22' => ['views' => 7, 'actions' => 5]]"
  ```
  Will accept a "from" date timestamp value and a "to" date timestamp value that will act as the date range.
  - Accepts a GET request that will echo a JSON object string that contains the total views and actions for either all
  themes or all organizations for all days. Eg output:
  ```
  "['1' => ['views' => 10, 'actions' => 5], '2' => ['views' => 3, 'actions' => 0], '3' => ['views' => 7, 'actions' => 5]]"
  ```
  Will accept a "type" string value equal to either "organization" or "theme". That "type" will determine the parent key's
  value (either theme id or organization id). 

###Environment Requirements
 - PHP 7.X
 - SQLLite

You are free to use any other supplementing frameworks, libraries, etc as you see fit. However, your solution will be tested
using the built in PHP webserver and must meet the following guidelines:

- SQLLite database contains a populated summary table and clicks table meets pruning specifications.
- Managing data sets in PHP. Please refrain from using non-PHP solutions such as database triggers.


 ###Installing Requirements

 ####PHP
 This repo requires at least PHP 7.3. This test assumes you will have access to PHP's built in webserver within the repos directory.
 For installation instructions, please see: https://www.php.net/manual/en/install.php.
 
 ####Composer
 This repo utilizes composer for package management. For installation instructions, please see: https://getcomposer.org/doc/00-intro.md.

 ####SQLLite 
 This repo utilizes a sqllite database in order to store the statistical information for the report page. For installation instructions,
 please see: https://www.sqlite.org/quickstart.html. Note: this wiki assumes that the sqlite-tools package (that meets your requirements)
 was downloaded and installed.


 ###Initilizing Repo

 ####Composer
  This exercise relies on the faker library. Please install it via composer by:
  ```
  #After navigating to the directory that contains this repo:
  > composer install
  ```
 ####Create and Populate Database
  This exercise relies on a SQLLite that is prepopulated with fake data. In order to create/populate your database, please run the
  following command:
  ```
  #After navigating to the directory that contains this repo:
  > php setup.php
  ```
  This process may take a few minutes. A success message will display once the script is finished creating/populating your database.