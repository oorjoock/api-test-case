<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    use IdTrait;

    /**
     * @var ArrayCollection|TransactionEntry[]
     *
     * @ORM\OneToMany(
     *    targetEntity="App\Entity\TransactionEntry",
     *    mappedBy="transaction",
     *    orphanRemoval=true,
     *    cascade={"all"}
     *)
     */
    private $transactionEntries;

    public function __construct()
    {
        $this->transactionEntries = new ArrayCollection();
    }

    /**
     * @return Transaction
     */
    public static function open()
    {
        return new self();
    }

    /**
     * @return Collection|TransactionEntry[]
     */
    public function getTransactionEntries(): Collection
    {
        return $this->transactionEntries;
    }

    /**
     * @param TransactionEntry $transactionEntry
     *
     * @return $this
     */
    public function removeTransactionEntry(TransactionEntry $transactionEntry): self
    {
        if ($this->transactionEntries->contains($transactionEntry)) {
            $this->transactionEntries->removeElement($transactionEntry);
            if ($transactionEntry->getTransaction() === $this) {
                $transactionEntry->setTransaction(null);
            }
        }

        return $this;
    }

    /**
     * @param Account $account
     * @param $amount
     *
     * @return $this
     */
    public function addEntry(
        Account $account,
        $amount
    ) {
        $entry = TransactionEntry::create(
            $account,
            $amount,
            $this
        );

        $this->transactionEntries[] = $entry;

        return $this;
    }

}

