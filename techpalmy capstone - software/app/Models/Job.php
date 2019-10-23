<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Job extends Model
{
    use SearchableTrait;
    protected $primaryKey = 'ID';

    public function company(){
        return $this->belongsTo('App\Models\Company', 'companyID');
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
            'jobs.position' => 10,
            'jobs.description' => 4,
        ],
        // 'joins' => [
        //     'posts' => ['users.id','posts.user_id'],
        // ], // For searching relationships
    ];
}
