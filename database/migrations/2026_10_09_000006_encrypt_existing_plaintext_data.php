<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Encrypted values are long, so make sure the columns are TEXT.
        Schema::table('users', function (Blueprint $table) {
            $table->text('phone')->nullable()->change();
            $table->text('address')->nullable()->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->text('notes')->nullable()->change();
        });

        // Encrypt rows that are still plain text (skips rows already encrypted).
        $this->encryptColumn('users', ['phone', 'address']);
        $this->encryptColumn('orders', ['notes']);
    }

    public function down(): void
    {
        // Intentionally empty: decrypting data back to plain text is not wanted.
    }

    private function encryptColumn(string $table, array $columns): void
    {
        DB::table($table)->orderBy('id')->each(function ($row) use ($table, $columns) {
            $update = [];

            foreach ($columns as $col) {
                $value = $row->$col;

                if ($value === null || $value === '') {
                    continue;
                }

                try {
                    Crypt::decryptString($value);   // already encrypted
                } catch (\Throwable $e) {
                    $update[$col] = Crypt::encryptString($value);
                }
            }

            if ($update) {
                DB::table($table)->where('id', $row->id)->update($update);
            }
        });
    }
};