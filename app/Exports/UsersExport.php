<?php

namespace App\Exports;

use App\Product;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    private $fields = [];
    private $type;
    private $typeAvailable;
    public static $numberRows;

    public function __construct(array $fields, string $type)
    {
        $this->fields = $fields;
        $this->type = $type;
        $this->typeAvailable = Product::groupBy('type_id')->pluck('type_id')->toArray();
    }

    /**
    * Return data of users.
    *
    * @return object
    */
    public function collection()
    {
        if(in_array('count_of_products', $this->fields)){

            unset($this->fields[array_search('count_of_products', $this->fields)]);
            $data = User::select($this->fields)->withCount('products AS count_of_products')->get();

        }

        if($this->type == 0) {

            $data = User::select($this->fields)->has('products', '=', 0)->get();

        }elseif ($this->type && in_array($this->type, $this->typeAvailable)){

            $data = User::select($this->fields)->whereHas('products', function($query){
                $query->where('type_id', $this->type);
            })->get();

        }else{

            $data = User::select($this->fields)->get();

        }

        self::$numberRows = count($data);

        return $data;
    }

    /**
     * Store values in table.
     *
     * @return array
     */
    public function map($row): array
    {
        $arr = [];
        foreach ($this->fields as $field){
            $arr[] = $row->$field;
        }
        return $arr;
    }

    /**
     * Return head for table.
     *
     * @return mixed
     */
    public function headings(): array
    {
        return $this->fields;
    }
}
