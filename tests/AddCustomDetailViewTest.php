<?php


use Robin\Api\Collections\DetailsView;
use Robin\Api\Models\Views\Details\Detail;

class AddCustomDetailViewTest extends TestCase
{

    public function testCanAddCustomDetailView()
    {
        $details = new DetailsView();
        $custom = CustomDetailsView::make("foo", "bar");

        $details->addColumns($custom, "Dummy");
        $array = $details->first()->toArray();
        $this->assertArrayHasKey("foo_bar", $array['data']);
        dump($details->first()->toJson());
    }
}


class CustomDetailsView extends Detail
{

    public $fooBar;

    public $barFoo;

    public static function make($foo, $bar)
    {
        $view = new static;

        $view->fooBar = $foo;
        $view->barFoo = $bar;

        return $view;
    }
}