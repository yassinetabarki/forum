<?php


namespace App\Filters;


use Illuminate\Http\Request;

abstract class Filters
{
    protected $request;

    /**
     * @var \Illuminate\Database\Query\Builder
    */
    Protected $builder;

    protected $filters=[];

    public function __construct(Request $request)
    {
        $this->request=$request;
    }

    //it will accept the qurey builder
    public function apply($builder)
    {
        $this->builder=$builder;

       foreach ( $this->getFilters() as $filter => $value) {
           if (method_exists($this, $filter)) {
               $this->$filter($value);
           }
       }
        return $this->builder ;

    }

    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
