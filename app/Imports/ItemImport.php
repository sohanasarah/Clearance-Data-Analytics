<?php

namespace clearance_data_analytics\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use clearance_data_analytics\Item;
use clearance_data_analytics\Brand;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class ItemImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    protected $rowNum;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $rowNum = ++$this->rowNum;

        $brand_id = Brand::where('id', $row['brand_id'])->first();

        if (is_null($brand_id)) {
            $error[] = 'Brand ID does not exist! Try Again';
            $failures[] = new Failure($rowNum, 'brand', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }

        return new Item([
            'item_code'    => $row['item_code'],
            'brand_id'     => $row['brand_id'],
            'item_name'    => $row['item_name'],
            'status'       => $row['status']
        ]);
    }

    public function rules(): array
    {
        return [
            '*.item_code'      => 'required|unique:items|max:16',
            '*.item_name'      => 'required|unique:items|max:48',
            '*.brand_id'       => 'required|numeric',
            '*.status'         => 'required'
        ];
    }
    
    public function batchSize(): int
    {
        return 1000;
    }
}
