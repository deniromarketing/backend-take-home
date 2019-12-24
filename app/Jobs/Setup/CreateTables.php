<?php
 
namespace App\Jobs\Setup;
 
/**
 * SQLite Create Table Demo
 * Source: https://www.sqlitetutorial.net/sqlite-php/create-tables/
 */
class CreateTables {
 
    /**
     * Create statement for the clicks table
     *
     * @var string
     */
    private $clicks_table = 'CREATE TABLE IF NOT EXISTS clicks (
      id INTEGER PRIMARY KEY,
      user_id INTEGER NOT NULL,
      view INTEGER NOT NULL,
      action INTEGER NOT NULL,
      created_at DATETIME
    )';

    /**
     * Create statement for the users table
     *
     * @var string
     */
    private $users_table = 'CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY,
        organization_id INTEGER NOT NULL,
        campaign_id INTEGER NOT NULL,
        device TEXT NOT NULL,
        created_at DATETIME
      )';

    /**
     * Create statement for the organizations table
     *
     * @var string
     */
    private $organizations_table = 'CREATE TABLE IF NOT EXISTS organizations (
        id INTEGER PRIMARY KEY,
        theme_id INTEGER NOT NULL,
        created_at DATETIME
      )';

    /**
     * Create statement for the campaigns table
     *
     * @var string
     */
    private $campaigns_table = 'CREATE TABLE IF NOT EXISTS campaigns (
        id INTEGER PRIMARY KEY,
        created_at DATETIME
      )';

    /**
     * Create statement for the themes table
     *
     * @var string
     */
    private $themes_table = 'CREATE TABLE IF NOT EXISTS themes (
        id INTEGER PRIMARY KEY,
        created_at DATETIME
      )';

    /**
     * Create statement for the summary stats table
     *
     * @var string
     */
    private $summary_table = 'CREATE TABLE IF NOT EXISTS summary (
      id INTEGER PRIMARY KEY,
      date DATETIME,
      campaign_id INTEGER NOT NULL,
      views INTEGER NOT NULL,
      actions INTEGER NOT NULL
    )';

    /**
     * PDO object
     * @var \PDO
     */
    private $pdo;
 
    /**
     * connect to the SQLite database
     */
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
 
    /**
     * create tables 
     */
    public function createTables() {
        $commands = [
          $this->users_table, 
          $this->clicks_table, 
          $this->organizations_table, 
          $this->campaigns_table, 
          $this->themes_table,
          $this->summary_table
        ];
        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $this->pdo->exec($command);
        }
    }
 
    /**
     * get the table list in the database
     */
    public function getTableList() {
 
        $stmt = $this->pdo->query("SELECT name
                                   FROM sqlite_master
                                   WHERE type = 'table'
                                   ORDER BY name");
        $tables = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $tables[] = $row['name'];
        }
 
        return $tables;
    }
 
}