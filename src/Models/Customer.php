<?php namespace Robin\Api\Models;


use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Robin\Api\Traits\DateFormatter;
use Robin\Api\Traits\ModelFormatter;
use Robin\Api\Models\Views\Panel;
use Illuminate\Contracts\Support\Jsonable;

class Customer implements Jsonable, Arrayable
{
    use ModelFormatter;
    use DateFormatter;

    public $emailAddress;

    /**
     * @var Carbon
     */
    public $customerSince;

    public $orderCount;

    public $totalSpent;

    public $panelView;

    /**
     * @param string $email
     * @param Carbon $customerSince
     * @param int $ordersCount
     * @param string $totalSpend
     * @param Panel $panelView
     * @return Customer
     */
    public static function make($email, Carbon $customerSince, $ordersCount, $totalSpend, Panel $panelView)
    {
        $robinCustomer = new static();

        $robinCustomer->emailAddress = $email;
        $robinCustomer->customerSince = static::formatDate($customerSince, '-');
        $robinCustomer->orderCount = $ordersCount;
        $robinCustomer->totalSpent = $totalSpend;
        $robinCustomer->panelView = $panelView;
        return $robinCustomer;
    }
}