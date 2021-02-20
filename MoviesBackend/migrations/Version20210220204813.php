<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210220204813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add new column in table movies';
    }

    public function up(Schema $schema) : void
    {
      $table = $schema->getTable('movies');
      $table->addColumn('is_deleted', 'boolean',['default' => false]);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('movies');
        $table->renameColumn('is_deleted');
    }
}
