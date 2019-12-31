<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionEntryRepository")
 */
class TransactionEntry
{
    use IdTrait;

    /**
     * @var Transaction
     *
     * @ORM\ManyToOne(
     *    targetEntity="App\Entity\Transaction",
     *    inversedBy="transactionEntries"
     * )
     * @ORM\JoinColumn(nullable=false)
     */
    private $transaction;

    /**
     * @var Account|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Account")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @var string
     *
     * @ORM\Column(
     *     precision=7,
     *     scale=2,
     *     type="decimal"
     * )
     */
    private $amount;

    /**
     * @param Account $account
     * @param $amount
     * @param Transaction $transaction
     */
    private function __construct(
        Account $account,
        $amount,
        Transaction $transaction
    ) {
        $this->account = $account;
        $this->amount = $amount;
        $this->transaction = $transaction;
    }

    /**
     * @return Transaction|null
     */
    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    /**
     * @param Transaction|null $transaction
     *
     * @return $this
     */
    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        return $this;
    }

    /**
     * @return Account|null
     */
    public function getAccount(): ?Account
    {
        return $this->account;
    }

    /**
     * @param Account|null $account
     *
     * @return $this
     */
    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @param Account $account
     * @param $amount
     * @param Transaction $transaction
     *
     * @return TransactionEntry
     */
    public static function create(
        Account $account,
        $amount,
        Transaction $transaction
    ) {
        return new self(
            $account,
            $amount,
            $transaction
        );
    }

    /**
     * @return string|null
     */
    public function getAmount(): ?string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     *
     * @return $this
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }


}

