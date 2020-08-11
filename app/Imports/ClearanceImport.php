<?php

namespace clearance_data_analytics\Imports;

use clearance_data_analytics\Clearance;
use clearance_data_analytics\Calendar;
use clearance_data_analytics\Item;


use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class ClearanceImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $calendar = Calendar::where('calendar_year', $row['year'])
                        ->Where('calendar_period', $row['month'])
                        ->first();

        $item   = Item::where('item_code', $row['item'])->first();

        $row['calendar_id'] = $calendar->id;
        $row['item_id'] = $item->id;

        return new Clearance([
            'calendar_id'  => $row['calendar_id'],
            'item_id'      => $row['item_id'],
            'measure'      => $row['measure'],
            'figure'       => $row['figure']
        ]);
    }

    public function rules(): array
    {
        return [
            'year' => 'required|numeric',
            'month' => 'required|numeric',
            'item_id' => 'required|numeric',
            'figure' => 'required|numeric',
            'measure'  => 'required|max:48'
        ];
    }

    
    public function batchSize(): int
    {
        return 1000;
    }

    



}
