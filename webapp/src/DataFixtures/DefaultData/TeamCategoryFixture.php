<?php declare(strict_types=1);

namespace App\DataFixtures\DefaultData;

use App\Entity\TeamCategory;
use Doctrine\Persistence\ObjectManager;

class TeamCategoryFixture extends AbstractDefaultDataFixture
{
    public const SYSTEM_REFERENCE = 'system';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        if (!($system = $manager->getRepository(TeamCategory::class)->findOneBy(['name' => 'System']))) {
            $system = (new TeamCategory())
                ->setName('System')
                ->setSortorder(9)
                ->setColor('#ff2bea')
                ->setVisible(false);
            $manager->persist($system);
        }
        if (!($selfRegistered = $manager->getRepository(TeamCategory::class)->findOneBy(['name' => 'Self-Registered']))) {
            $selfRegistered = (new TeamCategory())
                ->setName('Self-Registered')
                ->setSortorder(8)
                ->setColor('#33cc44');
            $manager->persist($selfRegistered);
        }
        $manager->flush();

        $this->addReference(static::SYSTEM_REFERENCE, $system);
    }
}
