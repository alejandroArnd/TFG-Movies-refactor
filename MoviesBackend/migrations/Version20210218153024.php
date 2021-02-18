<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210218153024 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table movies';
    }

    public function up(Schema $schema) : void
    {   
        $table = $schema->createTable('movies');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 255]);
        $table->addColumn('overview', 'text', ['length' => 1000]);
        $table->addColumn('release_date','date');
        $table->addColumn('duration','time');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('movies');
    }
}
