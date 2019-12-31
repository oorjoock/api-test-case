<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    use IdTrait;

    /**
     * @var string|null
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     *)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Account", mappedBy="user")
     */
    private $account;

    public function __construct()
    {
        $this->account = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccount(): Collection
    {
        return $this->account;
    }

    /**
     * @param Account $account
     *
     * @return $this
     */
    public function addAccount(Account $account): self
    {
        if (!$this->account->contains($account)) {
            $this->account[] = $account;
            $account->setUser($this);
        }

        return $this;
    }

    /**
     * @param Account $account
     *
     * @return $this
     */
    public function removeAccount(Account $account): self
    {
        if ($this->account->contains($account)) {
            $this->account->removeElement($account);
            if ($account->getUser() === $this) {
                $account->setUser(null);
            }
        }

        return $this;
    }

}

