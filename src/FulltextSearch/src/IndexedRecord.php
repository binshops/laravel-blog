<?php

namespace HessamCMS\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Model;

class IndexedRecord extends Model
{
    protected $table = 'laravel_fulltext';

    public function __construct(array $attributes = [])
    {
        $this->connection = config('hessamcms.search.db_connection');

        parent::__construct($attributes);
    }

    public function indexable()
    {
        return $this->morphTo();
    }

    public function updateIndex()
    {
        $this->setAttribute('indexed_title', $this->indexable->getIndexTitle());
        $this->setAttribute('indexed_content', $this->indexable->getIndexContent());
        $this->save();
    }
}
