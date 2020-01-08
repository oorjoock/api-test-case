<?php

namespace App\DataFixtures;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setName('test'.$i);
            $account = new Account();
            $user->addAccount($account);

            $transaction = Transaction::open();
            $transaction->addEntry(
                $account,
                1000
            );

            $manager->persist($user);
            $manager->persist($account);
            $manager->persist($transaction);
        }

        $manager->flush();
    }

}

