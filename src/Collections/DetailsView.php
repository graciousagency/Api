<?php


namespace Robin\Api\Collections;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Robin\Api\Models\Views\Details\DetailViewItem;
use Robin\Api\Traits\ModelFormatter;


/**
 * Class Details
 * @package Robin\Connect\Robin\Collections
 *
 * @method DetailViewItem get($index)
 */
class DetailsView extends Collection
{
    public function addRows($details, $caption = '')
    {
        return $this->addDetailViewItem("rows", $details, $caption);
    }

    public function addDetails($details)
    {
        return $this->addDetailViewItem("details", $details);
    }

    public function addColumns($details, $caption = '')
    {
        return $this->addDetailViewItem("columns", $details, $caption);
    }

    private function addDetailViewItem($kind, $details, $caption = '')
    {
        $this->push(DetailViewItem::make($kind, $details, $caption));

        return $this;
    }
}