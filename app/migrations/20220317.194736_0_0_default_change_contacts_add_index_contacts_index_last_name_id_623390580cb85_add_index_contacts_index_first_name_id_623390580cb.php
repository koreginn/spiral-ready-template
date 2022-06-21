<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefault389aa5a712188cec7b9eca6c7e4c5a52 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('contacts')
            ->addIndex(["last_name", "id"], [
                'name'   => 'contacts_index_last_name_id_623390580cb85',
                'unique' => false
            ])
            ->addIndex(["first_name", "id"], [
                'name'   => 'contacts_index_first_name_id_623390580cb96',
                'unique' => false
            ])
            ->addIndex(["phone", "id"], [
                'name'   => 'contacts_index_phone_id_623390580cb9e',
                'unique' => false
            ])
            ->dropIndex(["user"])
            ->update();
    }

    public function down(): void
    {
        $this->table('contacts')
            ->addIndex(["user"], [
                'name'   => 'contacts_index_user_62338d04460d0',
                'unique' => false
            ])
            ->dropIndex(["last_name", "id"])
            ->dropIndex(["first_name", "id"])
            ->dropIndex(["phone", "id"])
            ->update();
    }
}
