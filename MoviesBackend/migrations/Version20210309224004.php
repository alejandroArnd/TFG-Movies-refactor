<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210309224004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create column acessible_path in movies table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('movies');
        $table->addColumn('accessible_path', 'string',['length' => 255])->setNotnull(true);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('movies');
        $table->renameColumn('accessible_path');
    }
}
