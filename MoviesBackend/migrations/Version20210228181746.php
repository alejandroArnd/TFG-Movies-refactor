<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210228181746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create table user';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('user');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('username', 'string', ['length' => 180])->setNotnull(true);
        $table->addColumn('email', 'string', ['length' => 255])->setNotnull(true);
        $table->addColumn('password','string',['length' => 255])->setNotnull(true);
        $table->addColumn('roles','json')->setNotnull(true);

        $table->setPrimaryKey(['id']);

        $table->addUniqueIndex(['username']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user');
    }
}
