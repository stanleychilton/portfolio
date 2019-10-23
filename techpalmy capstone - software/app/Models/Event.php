<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Event extends Model
{
    use SearchableTrait;
    protected $primaryKey = 'ID';

    public function techgroup(){
        return $this->belongsTo('App\Models\TechGroup', 'techgroupID'); // techgroupID is the foreign key
    }

    public function user(){
        return $this->belongsTo('App\Models\User', 'users_id'); // users_id is the foreign key stored in events.
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address', 'addresses_id'); // addresses_id is the foreign key stored in events
    }

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        /**
         * Columns and their priority in search results.
         * Columns with higher values are more important.
         * Columns with equal values have equal importance.
         *
         * @var array
         */

        'columns' => [
            'events.name' => 10,
            'events.description' => 5,
        ],
    ];
}
