<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefault5a2bf35f34debe72891801bae0ad6f12 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('contacts')
            ->addIndex(["user"], [
                'name'   => 'contacts_index_user_62338d04460d0',
                'unique' => false
            ])
            ->update();
    }

    public function down(): void
    {
        $this->table('contacts')
            ->dropIndex(["user"])
            ->update();
    }
}
