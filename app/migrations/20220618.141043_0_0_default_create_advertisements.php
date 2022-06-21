<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefaultD46d27801dacd0ff4d9141cb80745d3a extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('advertisements')
            ->addColumn('id', 'primary', [
                'nullable' => false,
                'default'  => null
            ])
            ->addColumn('post', 'string', [
                'nullable' => false,
                'default'  => null,
                'size'     => 255
            ])
            ->addColumn('created_at', 'datetime', [
                'nullable' => false,
                'default'  => null
            ])
            ->addIndex(["post"], [
                'name'   => 'advertisements_index_post_62addce3660ae',
                'unique' => false
            ])
            ->setPrimaryKeys(["id"])
            ->create();
    }

    public function down(): void
    {
        $this->table('advertisements')->drop();
    }
}
