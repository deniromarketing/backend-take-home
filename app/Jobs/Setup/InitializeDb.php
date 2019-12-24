<?php
 
use App\SQLiteConnection as SQLiteConnection;
use App\Jobs\Setup\CreateTables as CreateTables;
use App\Jobs\Setup\SeedTables as SeedTables;

$pdo = (new SQLiteConnection())->connect();
if ($pdo != null) {
    echo "Creating tables \n";

    $jobInit = new CreateTables($pdo);
    $jobInit->createTables();

    $tables = $jobInit->getTableList();

    if (empty($tables)) {
        echo "No tables found \n";
        exit;
    }

    if (count($tables) !== 4) {
        echo "Only " . count($tables) . " / 4 tables created! \n";
        exit;
    }

    echo "Tables created. Seeding data \n";

    $jobSeed = new SeedTables($pdo);
    $jobSeed();

    echo "Success! All tables created and seeded! \n";
} else {
    echo "Cant create connection or database \n";
}

?>