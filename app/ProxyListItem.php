<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProxyListItem extends Model
{
    const SEARCH_CRITERIA = [
        'value' => ['value'],
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'proxylistitems';

    public function getCreator()
    {
        return User::findOrFail($this->created_by);
    }
}
