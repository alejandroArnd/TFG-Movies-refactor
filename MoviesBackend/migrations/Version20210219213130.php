<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\TimeType;


final class Version20210219213130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Change type of column duration in table movies';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('movies');
        $table->getColumn('duration')->setType(new IntegerType());
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('movies');
        $table->getColumn('duration')->setType(new TimeType());
    }
}
