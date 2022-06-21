<?php

declare(strict_types=1);

namespace App\Database;

use Cycle\Annotated\Annotation as Cycle;

/**
 * @Cycle\Entity(repository="\App\Repository\AdvertisementRepository")
 * @Cycle\Table(
 *  indexes={
 *    @Cycle\Table\Index(columns = {"post"})
 *  }
 * )
 */
class Advertisement
{
    /**
     * @Cycle\Column(type = "primary")
     */
    public $id;

    /**
     * @Cycle\Column(type = "string")
     */
    public $post;

    /**
     * @Cycle\Column(type = "datetime")
     */
    public $created_at;
}
