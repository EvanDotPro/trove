<?php

namespace Tv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161126011855 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $user = $schema->createTable('read_user');

        $user->addColumn('id', 'string', ['length' => 36]);
        $user->addColumn('username', 'string', ['length' => 50]);
        $user->addColumn('password', 'binary', ['length' => 60]);
        $user->addUniqueIndex(['username']);
        $user->setPrimaryKey(['id']);
    }

    public function down(Schema $schema)
    {
        $schema->dropTable('read_user');
    }
}
