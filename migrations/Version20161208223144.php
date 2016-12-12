<?php

namespace Tv\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161208223144 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $channel = $schema->createTable('read_video');

        $channel->addColumn('videoId', 'string', ['length' => 36]);
        $channel->addColumn('source', 'string', ['length' => 10]);
        $channel->addColumn('sourceId', 'string', ['length' => 36]);
        $channel->addColumn('duration', 'integer', ['default' => 0]);
        $channel->addColumn('title', 'string', ['default' => null, 'notnull' => false, 'length' => 255]);
        $channel->addColumn('channelId', 'string', ['length' => 36]);
        $channel->addColumn('userId', 'string', ['length' => 36]);
        $channel->addIndex(['channelId']);
        $channel->setPrimaryKey(['videoId']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $schema->dropTable('read_video');
    }
}
