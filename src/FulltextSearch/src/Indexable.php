<?php

namespace BinshopsBlog\Laravel\Fulltext;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property \BinshopsBlog\Laravel\Fulltext\IndexedRecord|null $indexedRecord
 */
trait Indexable
{
    /**
     * Boot the trait.
     */
    public static function bootIndexable()
    {
        static::observe(new ModelObserver());
    }

    public function getIndexContent()
    {
        return $this->getIndexDataFromColumns($this->indexContentColumns);
    }

    public function getIndexTitle()
    {
        return $this->getIndexDataFromColumns($this->indexTitleColumns);
    }

    public function indexedRecord()
    {
        return $this->morphOne(IndexedRecord::class, 'indexable');
    }

    public function indexRecord()
    {
        if (null === $this->indexedRecord) {
            $this->indexedRecord = new IndexedRecord();
            $this->indexedRecord->indexable()->associate($this);
        }
        $this->indexedRecord->updateIndex();
    }

    public function unIndexRecord()
    {
        if (null !== $this->indexedRecord) {
            $this->indexedRecord->delete();
        }
    }

    protected function getIndexDataFromColumns($columns)
    {
        $indexData = [];
        foreach ($columns as $column) {
            if ($this->indexDataIsRelation($column)) {
                $indexData[] = $this->getIndexValueFromRelation($column);
            } else {
                $indexData[] = trim($this->{$column});
            }
        }

        return implode(' ', array_filter($indexData));
    }

    /**
     * @param $column
     *
     * @return bool
     */
    protected function indexDataIsRelation($column)
    {
        return (int) strpos($column, '.') > 0;
    }

    /**
     * @param $column
     *
     * @return string
     */
    protected function getIndexValueFromRelation($column)
    {
        list($relation, $column) = explode('.', $column);
        if (is_null($this->{$relation})) {
            return '';
        }

        $relationship = $this->{$relation}();
        if ($relationship instanceof BelongsTo || $relationship instanceof HasOne) {
            return $this->{$relation}->{$column};
        }

        return $this->{$relation}->pluck($column)->implode(', ');
    }
}
