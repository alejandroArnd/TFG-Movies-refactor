<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210223210929 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table between movie table and genre table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('movies_genre');
        $table->addColumn('movies_id', 'integer');
        $table->addColumn('genre_id', 'integer');

        $tableMovie = $schema->getTable('movies');
        $tableGenre = $schema->getTable('genre');

        $table->addForeignKeyConstraint($tableMovie, ['movies_id'], ['id'], ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'], 'FK_movie');
        $table->addForeignKeyConstraint($tableGenre, ['genre_id'], ['id'], ['onUpdate' => 'CASCADE', 'onDelete' => 'CASCADE'], 'FK_genre');
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('movies_genre');

        $table->removeForeignKey('FK_movie');
        $table->removeForeignKey('FK_genre');

        $schema->dropTable('movies_genre');
    }
}
