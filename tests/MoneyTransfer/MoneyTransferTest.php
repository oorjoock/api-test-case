<?php

namespace App\Tests\MoneyTransfer;

use App\Entity\User;
use App\Exception\NotEnoughMoneyException;
use App\Service\Transaction\TransactionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MoneyTransferTest extends KernelTestCase
{
    private const TEST_USERNAME1 = 'test0';
    private const TEST_USERNAME2 = 'test1';

    /**
     * @var \Doctrine\Persistence\ObjectManager
     */
    private $entityManager;

    /**
     * @var \App\Service\FundsTransferProcessor
     */
    private $fundsTransferProcessor;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $userRepository;

    /**
     * @var TransactionServiceInterface
     */
    private $transactionService;

    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel
            ->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->fundsTransferProcessor = $kernel
            ->getContainer()
            ->get('app.funds.transfer_processor');

        $this->userRepository = $this
            ->entityManager
            ->getRepository(User::class);

        $this->transactionService = $kernel
            ->getContainer()
            ->get('app.transaction.doctrine_service');
    }

    /**
     * @throws NotEnoughMoneyException
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function testSuccessfulTransaction()
    {
        $this
            ->transactionService
            ->start();

        /** @var User $sourceUser */
        $sourceUser = $this
            ->userRepository
            ->findOneBy(['name' => self::TEST_USERNAME1]);

        /** @var User $targetUser */
        $targetUser = $this
            ->userRepository
            ->findOneBy(['name' => self::TEST_USERNAME2]);

        $this
            ->fundsTransferProcessor
            ->transfer(
                $sourceUser->getId(),
                $targetUser->getId(),
                \rand(1,100)
            );

        $this
            ->transactionService
            ->commit();

        $this->assertTrue(true);
    }

    /**
     * @throws NotEnoughMoneyException
     */
    public function testUnsuccessfulTransaction()
    {
        $this->expectException(NotEnoughMoneyException::class);

        /** @var User $sourceUser */
        $sourceUser = $this
            ->userRepository
            ->findOneBy(['name' => self::TEST_USERNAME1]);

        /** @var User $targetUser */
        $targetUser = $this
            ->userRepository
            ->findOneBy(['name' => self::TEST_USERNAME2]);

        $this
            ->fundsTransferProcessor
            ->transfer(
                $sourceUser->getId(),
                $targetUser->getId(),
                \rand(1500,10000)
            );
    }

}

