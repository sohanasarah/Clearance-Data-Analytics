<?php

namespace clearance_data_analytics\Imports;

use clearance_data_analytics\Clearance;
use clearance_data_analytics\Calendar;
use clearance_data_analytics\Item;
use clearance_data_analytics\Code;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class ClearanceImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    protected $rowNum;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $rowNum= ++$this->rowNum;

        $calendar = Calendar::where('calendar_year', $row['year'])
            ->Where('calendar_period', $row['month'])
            ->first();

        $item = Item::where('item_code', $row['item'])->first();

        $measure = Code::where('code_value', $row['measure'])->first();

        if (is_null($calendar)) {
            $error[] = 'Calendar Record does not exist! Try Again';
            $failures[] = new Failure($rowNum, 'calendar', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }
        if (is_null($item)) {
            $error[] = 'Item code does not exist in Item Master! Try Again';
            $failures[] = new Failure($rowNum, 'item', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }
        if (is_null($measure)) {
            $error[] = 'Measure does not exist in Code Master! Try Again';
            $failures[] = new Failure($rowNum, 'measure', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }

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
            'item' => 'required|numeric',
            'figure' => 'required|numeric',
            'measure'  => 'required|max:48'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
