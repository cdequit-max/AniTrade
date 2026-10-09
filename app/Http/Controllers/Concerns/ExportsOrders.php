<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportsOrders
{
    /** Stream the given orders as a CSV download. */
    protected function exportOrders(Builder|Relation $query, string $partyLabel, string $partyRelation): StreamedResponse
    {
        $orders = $query->with(['produce', $partyRelation])->latest()->get();

        return response()->streamDownload(function () use ($orders, $partyLabel, $partyRelation) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Reference', 'Produce', $partyLabel, 'Quantity', 'Total (PHP)', 'Fulfillment', 'Status', 'Payment', 'Date'], ',', '"', '\\');

            foreach ($orders as $o) {
                fputcsv($out, array_map([$this, 'csvSafe'], [
                    $o->reference,
                    $o->produce?->name,
                    $o->{$partyRelation}?->displayName(),
                    $o->quantity,
                    $o->total,
                    $o->fulfillment,
                    $o->status,
                    $o->payment_status,
                    $o->created_at->format('Y-m-d H:i'),
                ]), ',', '"', '\\');
            }

            fclose($out);
        }, 'anitrade-orders.csv', ['Content-Type' => 'text/csv']);
    }

    /** Neutralise spreadsheet formula injection. */
    protected function csvSafe(mixed $value): string
    {
        $value = (string) $value;

        return $value !== '' && str_contains('=+-@', $value[0]) ? "'".$value : $value;
    }
}
