<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Company extends Model
{
    use SearchableTrait;
    protected $primaryKey = 'ID';

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'comp_id');
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
            'companies.name' => 10,
            'companies.industry' => 5,
            'companies.technology' => 5,
            'companies.business' => 5,
            'companies.description' => 4,
        ],
        // 'joins' => [
        //     'posts' => ['users.id','posts.user_id'],
        // ], // For searching relationships
    ];

}
