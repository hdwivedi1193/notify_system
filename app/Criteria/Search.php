<?php
namespace App\Criteria;

use Baethon\LaravelCriteria\CriteriaInterface;
class Search implements CriteriaInterface
{
    private $field;

    private $value;

    public function __construct(string $field, string $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    public function apply($query)
    {
        $query->where($this->field, $this->value);
    }
}