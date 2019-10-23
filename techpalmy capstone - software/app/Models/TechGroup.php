<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class TechGroup extends Model
{   
    use SearchableTrait;
    protected $primaryKey = 'ID';
    protected $table = 'techgroups'; // <- here

    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'usertechgroups', 'Tech_id', 'User_id');
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
            'techgroups.name' => 10,
            'techgroups.website' =>5,
            'techgroups.description' => 3,
            
        ],
    ];
}
