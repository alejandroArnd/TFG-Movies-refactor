<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210226121945 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table review';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('review');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('title', 'string', ['length' => 255])->setNotnull(true);
        $table->addColumn('paragraph', 'text', ['length' => 1000])->setNotnull(true);
        $table->addColumn('score','float')->setNotnull(true);
        $table->addColumn('posting_date','date')->setNotnull(true);
        $table->addColumn('movies_id', 'integer')->setNotnull(true);

        $table->setPrimaryKey(['id']);

        $tableMovie = $schema->getTable('movies');
        $table->addForeignKeyConstraint($tableMovie, ['movies_id'], ['id'], ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'], 'FK_movie_review');
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('review');

        $table->removeForeignKey('FK_movie');

        $schema->dropTable('review');
    }
}
