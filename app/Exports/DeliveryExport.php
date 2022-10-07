<?php

namespace App\Exports;

use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class DeliveryExport implements FromCollection
{
    public Collection $deliveries;
    public function __construct($deliveries)
    {
        $this->deliveries = $deliveries;
    }
    public function headings()
    {
        return trans("orders.delivery.excel-header");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function collection(): Collection
    {
        $results = [$this->headings()];

        $data = [];
        foreach ($this->deliveries as $key => $delivery) {
            $data[$key][] = [
                $delivery->id,
                $delivery->order_id,
                $delivery->cost,
                $delivery->order->shipping_cost,
                $delivery->delivery_company->name,
                $delivery->created_at->format('Y-m-d'),];
            $results[] = $data[$key];
        }
        return new Collection($results);
    }
}
