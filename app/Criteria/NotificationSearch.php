<?php
namespace App\Criteria;

use Baethon\LaravelCriteria\CriteriaInterface;
use Carbon\Carbon;
class NotificationSearch implements CriteriaInterface
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
        $query->when($this->field == "expiration", function ($query) {
            return $query->whereDate($this->field, Carbon::parse($this->value)->format("Y-m-d"));
        }, function ($query) {
            return $query->where($this->field, $this->value);
        });
    }
}