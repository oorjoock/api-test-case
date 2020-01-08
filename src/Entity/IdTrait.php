<?php

namespace App\Entity;

trait IdTrait
{
    /**
     * @var string
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(
     *     type="guid",
     *     unique=true
     *)
     */
    private $id;

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

}
