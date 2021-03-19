<?php

namespace BinshopsBlog\Laravel\Fulltext;

class Search implements SearchInterface
{
    /**
     * @param string $search
     *
     * @return \Illuminate\Database\Eloquent\Collection|\BinshopsBlog\Laravel\Fulltext\IndexedRecord[]
     */
    public function run($search)
    {
        $query = $this->searchQuery($search);

        return $query->get();
    }

    /**
     * @param $search
     * @param $class
     *
     * @return \Illuminate\Database\Eloquent\Collection|\BinshopsBlog\Laravel\Fulltext\IndexedRecord[]
     */
    public function runForClass($search, $class)
    {
        $query = $this->searchQuery($search);
        $query->where('indexable_type', $class);

        return $query->get();
    }

    /**
     * @param string $search
     *
     * This search query is designed for post queries - todo:
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function searchQuery($search)
    {
        $termsBool = '';
        $termsMatch = '';

        if ($search) {
            $terms = TermBuilder::terms($search);

            $termsBool = '+'.$terms->implode(' +');
            $termsMatch = ''.$terms->implode(' ');
        }

        $titleWeight = str_replace(',', '.', (float) config('binshopsblog.search.weight.title', 1.5));
        $contentWeight = str_replace(',', '.', (float) config('binshopsblog.search.weight.content', 1.0));

        $query = IndexedRecord::query()
          ->whereRaw('MATCH (indexed_title, indexed_content) AGAINST (? IN BOOLEAN MODE)', [$termsBool])
          ->orderByRaw(
              '('.$titleWeight.' * (MATCH (indexed_title) AGAINST (?)) +
              '.$contentWeight.' * (MATCH (indexed_title, indexed_content) AGAINST (?))
             ) DESC',
                [$termsMatch, $termsMatch])
            ->limit(config('binshopsblog.search.limit-results'));

        $query->with(['indexable' => function ($query) {
            $query->with(['post' => function($query){
                $query->where('is_published', '=', true);
            }]);
        }]);

        return $query;
    }
}
