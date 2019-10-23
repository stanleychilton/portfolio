<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Consultant extends Model
{
    use SearchableTrait;
    protected $primaryKey = 'ID';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'con_id');
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
            'consultants.name' => 10,
            'consultants.expertise' => 5,
            'consultants.description' => 2,
        ],
    ];
}
