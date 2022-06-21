<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefault4ddedb07e8502fe3aa4bd4ae3a847337 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('contacts')
            ->alterColumn('last_name', 'binary', [
                'nullable' => false,
                'default'  => null
            ])
            ->alterColumn('first_name', 'binary', [
                'nullable' => false,
                'default'  => null
            ])
            ->alterColumn('phone', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('contacts')
            ->alterColumn('last_name', 'binary', [
                'nullable' => true,
                'default'  => null
            ])
            ->alterColumn('first_name', 'binary', [
                'nullable' => true,
                'default'  => null
            ])
            ->alterColumn('phone', 'text', [
                'nullable' => true,
                'default'  => null
            ])
            ->update();
    }
}
