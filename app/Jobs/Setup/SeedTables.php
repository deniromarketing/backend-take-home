<?php
 
namespace App\Jobs\Setup;

use Faker\Factory;
 
/**
 * Seed Tables Script
 */
class SeedTables {

    /**
     * PDO object
     * @var \PDO $pdo
     */
    private $pdo;

    /**
     * Faker object
     *
     * @var Factory $faker
     */
    private $faker;

    /**
     * Click creation count
     *
     * @var int $clickCount;
     */
    private $clickCount;

    /**
     * User creation count
     *
     * @var int $userCount;
     */
    private $userCount;

    /**
     * Organization creation count
     *
     * @var int $organizationCount;
     */
    private $organizationCount;

    /**
     * Campaign creation count
     *
     * @var int $campaignCount;
     */
    private $campaignCount;

    /**
     * Theme creation count
     *
     * @var int $themeCount;
     */
    private $themeCount;
 
    /**
     * Create instance
     *
     * @param \PDO $pdo
     */
    public function __construct(
        \PDO $pdo, 
        int $clickCount = 2000,
        int $userCount = 1000, 
        int $organizationCount = 50, 
        int $campaingCount = 150, 
        int $themeCount = 10
    ) {
        $this->pdo = $pdo;
        $this->faker = Factory::create();
        $this->clickCount = $clickCount;
        $this->userCount = $userCount; 
        $this->organizationCount = $organizationCount;
        $this->campaignCount = $campaingCount;
        $this->themeCount = $themeCount;
    }
 
    public function __invoke()
    {
        try {
            $this->process();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
 
    /**
     * Seed data into the database
     *
     * @return void
     */
    private function process()
    {
        $this->createThemes();
        $this->createOrganizations();
        $this->createCampaigns();
        $this->createUsers();
        $this->createClicks();
    }

    /**
     * Seed themes into the database
     *
     * @return void
     */
    private function createThemes(): void
    {
        echo "Create theme data \n";
        for ($i=1; $i <= $this->themeCount; $i++) {
            $time = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $query = "INSERT INTO themes (created_at)
                      VALUES ('{$time}')";
            $this->pdo->exec($query);
            echo "Progress: {$i}/{$this->themeCount} \r";
        }
        echo "Finished creating theme data \n";
    }

    /**
     * Seed organizations into the database
     *
     * @return void
     */
    private function createOrganizations(): void
    {
        echo "Create organization data \n";
        for ($i=1; $i <= $this->organizationCount; $i++) {
            $theme_id = (int) $this->pdo->query("SELECT id FROM themes ORDER BY RANDOM() LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['id'];
            $time = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $query = "INSERT INTO organizations (theme_id, created_at)
                      VALUES ({$theme_id}, '{$time}')";
            $this->pdo->exec($query);
            echo "Progress: {$i}/{$this->organizationCount} \r";
        }
        echo "Finished creating organization data \n";
    }

    /**
     * Seed campaigns into the database
     *
     * @return void
     */
    private function createCampaigns(): void
    {
        echo "Create campaign data \n";
        for ($i=1; $i <= $this->campaignCount; $i++) {
            $time = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $query = "INSERT INTO campaigns (created_at)
                      VALUES ('{$time}')";
            $this->pdo->exec($query);
            echo "Progress: {$i}/{$this->campaignCount} \r";
        }
        echo "Finished creating campaign data \n";
    }

    /**
     * Seed users into the database
     *
     * @return void
     */
    private function createUsers(): void
    {
        echo "Create user data \n";
        for ($i=1; $i <= $this->userCount; $i++) {
            $organization_id = (int) $this->pdo->query("SELECT id FROM organizations ORDER BY RANDOM() LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['id'];
            $campaign_id = (int) $this->pdo->query("SELECT id FROM campaigns ORDER BY RANDOM() LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['id'];
            $device = ['mobile', 'desktop'];
            $device_key = array_rand($device);
            $time = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $query = "INSERT INTO users (organization_id, campaign_id, device, created_at)
                      VALUES ({$organization_id}, {$campaign_id}, '{$device[$device_key]}', '{$time}')";
            $this->pdo->exec($query);
            echo "Progress: {$i}/{$this->userCount} \r";
        }
        echo "Finished creating user data \n";
    }

    /**
     * Seed clicks into the database
     *
     * @return void
     */
    private function createClicks(): void
    {
        echo "Create click data \n";
        for ($i=1; $i <= $this->clickCount; $i++) {
            $user_id = (int) $this->pdo->query("SELECT id FROM users ORDER BY RANDOM() LIMIT 1")->fetch(\PDO::FETCH_ASSOC)['id'];
            $view = rand(0,1);
            $action = $view ? rand(0,1) : 0;
            $time = $this->faker->dateTimeThisYear()->format('Y-m-d H:i:s');
            $query = "INSERT INTO clicks (user_id, view, action, created_at)
                      VALUES ({$user_id}, {$view}, '{$action}', '{$time}')";
            $this->pdo->exec($query);
            echo "Progress: {$i}/{$this->clickCount} \r";
        }
        echo "Finished creating click data \n";
    }
}