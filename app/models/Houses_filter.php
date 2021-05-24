<?php

use Phalcon\Mvc\Model;

class Houses_filter extends Model
{
    public $id;
    public $house_id;
    public $livings_count;
    public $bedr_count;
    public $toilets_count;
    public $storages_count;
    public $barths_count;
    public $total_count;
}