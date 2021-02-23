<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use DOMDocument;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20210223145323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table genre and add rows';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('genre');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('genre');
    }

    public function postUp(Schema $schema): void
    {
        $doc = new DOMDocument();

        $doc->load('/var/www/html/migrations/data/genreData.xml');
        $genres = $doc->getElementsByTagName('genre');
        foreach($genres as $genre){
          $this->connection->insert('genre', ['name' => $genre->getAttribute('name')]);
        }
    }
}
