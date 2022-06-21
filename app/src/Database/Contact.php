<?php

declare(strict_types=1);

namespace App\Database;

use Cycle\Annotated\Annotation as Cycle;

/**
 * @Cycle\Entity(repository="\App\Repository\ContactRepository")
 * @Cycle\Table(
 *  indexes={
 *    @Cycle\Table\Index(columns = {"last_name"}),
 *    @Cycle\Table\Index(columns = {"first_name"}),
 *    @Cycle\Table\Index(columns = {"phone"}),
 *  }
 * )
 */
class Contact
{
    /**
     * @Cycle\Column(type = "primary")
     */
    public $id;

    /**
     * @Cycle\Column(type = "blob")
     */
    public $last_name;

    /**
     * @Cycle\Column(type = "blob")
     */
    public $first_name;

    /**
     * @Cycle\Column(type = "string")
     */
    public $phone;

    /**
     * @Cycle\Column(type = "string")
     */
    public $email;

    /**
     * @Cycle\Column(type = "string")
     */
    public $user;

    /**
     * @Cycle\Column(type = "datetime")
     */
    public $created_at;

    /**
     * @Cycle\Column(type = "datetime", nullable = true)
     */
    public $deleted_at;

    public function getFullName(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }
}
