<?php

namespace Abordage\TableCard;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Card;

class TableCard extends Card
{
    public string $title = '';

    public array $rows = [];

    public $width = '1/3';

    public function __construct()
    {
        parent::__construct('abordage-table-card');
        if (request()->is('nova-api/metrics/*')) {
            return;
        }

        $this->rows = $this->rows();
    }

    public function rows(): array
    {
        return [];
    }

    /**
     * @param Model $model
     * @return string
     * @phpstan-ignore-next-line
     */
    private function getResourceUrl(Model $model): string
    {
        return config('nova.path') . '/resources/' . str_replace('_', '-', $model->getTable()) . '/' . $model->getKey();
    }

    public function jsonSerialize(): array
    {
        return array_merge([
            'title' => $this->title,
            'rows' => $this->rows,
        ], parent::jsonSerialize());
    }
}
