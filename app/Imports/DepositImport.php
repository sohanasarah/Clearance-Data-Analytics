<?php

namespace clearance_data_analytics\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use clearance_data_analytics\Deposit;
use clearance_data_analytics\Calendar;
use clearance_data_analytics\Manufacturer;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Validators\Failure;

class DepositImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
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

        $manufacturer = Manufacturer::where('short_name', $row['manufacturer'])->first();

        if (is_null($calendar)) {
            $error[] = 'Calendar Record does not exist! Try Again';
            $failures[] = new Failure($rowNum, 'calendar', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }
        if (is_null($manufacturer)) {
            $error[] = 'Manufacturer does not exist in Master! Try Again';
            $failures[] = new Failure($rowNum, 'manufacturer', $error, $row);
            throw new \Maatwebsite\Excel\Validators\ValidationException(
                \Illuminate\Validation\ValidationException::withMessages($error),
                $failures
            );
            return null;
        }

        $row['calendar_id']         = $calendar->id;
        $row['manufacturer_id']     = $manufacturer->id;

        return new Deposit([
            'calendar_id'    => $row['calendar_id'],
            'manufacturer_id'=> $row['manufacturer_id'],
            'vat_deposit'    => $row['vat_deposit'],
            'sd_deposit'     => $row['sd_deposit'],
            'hdsc_deposit'   => $row['hdsc_deposit'],
        ]);
    }

    public function rules(): array
    {
        return [
            'year' => 'required|max:4',
            'month' => 'required|max:2',
            'manufacturer' => 'required|string',
            'vat_deposit' => 'required|numeric',
            'sd_deposit' => 'required|numeric',
            'hdsc_deposit'  => 'required|numeric'
        ];
    }

    public function batchSize(): int
    {
        return 1000;
    }
}
