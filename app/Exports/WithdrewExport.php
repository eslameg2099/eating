<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class WithdrewExport implements FromCollection
{
    public Collection $withdrawals;
    public function __construct($withdrawals)
    {
        $this->withdrawals = $withdrawals;
    }
    public function headings()
    {
        return trans("wallets.excel-header");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection(): Collection
    {
        $results = [$this->headings()];

        $data = [];
        foreach ($this->withdrawals as $key => $withdrew) {
            $data[$key][] = [
                $withdrew->id,
                $withdrew->user->name,
                $withdrew->credit->bank_name,
                $withdrew->credit->account_name,
                $withdrew->credit->account_number,
                $withdrew->credit->iban_number,
                $withdrew->value,
            ];
            $results[] = $data[$key];
        }
        return new Collection($results);
    }
}
