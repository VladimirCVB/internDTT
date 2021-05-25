<?php

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class HousesFilterMigration_101
 */
class HousesFilterMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('houses_filter', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'house_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 10,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'livings_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'house_id'
                        ]
                    ),
                    new Column(
                        'bedr_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'livings_count'
                        ]
                    ),
                    new Column(
                        'toilets_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'bedr_count'
                        ]
                    ),
                    new Column(
                        'storages_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'toilets_count'
                        ]
                    ),
                    new Column(
                        'barths_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'storages_count'
                        ]
                    ),
                    new Column(
                        'total_count',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => false,
                            'size' => 100,
                            'after' => 'barths_count'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY')
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8mb4_general_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}
