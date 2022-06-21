<?php

declare(strict_types=1);

namespace App;

use App\Helper\Helper;
use Spiral\Migrations\Migration;

class FormattingCurrentNumbersMigration extends Migration
{
    protected const DATABASE = 'default';

    public function up(): void
    {
        ini_set('memory_limit', '-1');

        $contacts = $this->database()->table('contacts')->fetchAll();

        foreach ($contacts as $contact) {
            $phone = Helper::formattingPhone($contact['phone']);

            $query = $this->database()->table('contacts')->update([
                'phone' => $phone
            ], [
                'id' => $contact['id']
            ]);

            $query->run();
        }
    }

    public function down(): void
    {
    }
}
