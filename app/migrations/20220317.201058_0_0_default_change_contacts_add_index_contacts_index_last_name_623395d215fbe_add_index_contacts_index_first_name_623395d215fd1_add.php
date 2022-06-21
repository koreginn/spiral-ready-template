<?php

namespace Migration;

use Spiral\Migrations\Migration;

class OrmDefault28b6bf3e6f19f0938f61102a4a47aa92 extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        $this->table('contacts')
            ->addIndex(["last_name"], [
                'name'   => 'contacts_index_last_name_623395d215fbe',
                'unique' => false
            ])
            ->addIndex(["first_name"], [
                'name'   => 'contacts_index_first_name_623395d215fd1',
                'unique' => false
            ])
            ->addIndex(["phone"], [
                'name'   => 'contacts_index_phone_623395d215fd7',
                'unique' => false
            ])
            ->dropIndex(["last_name", "id"])
            ->dropIndex(["first_name", "id"])
            ->dropIndex(["phone", "id"])
            ->update();
    }

    public function down(): void
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
            ->dropIndex(["last_name"])
            ->dropIndex(["first_name"])
            ->dropIndex(["phone"])
            ->update();
    }
}
