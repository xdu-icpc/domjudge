<?php declare(strict_types=1);

namespace App\DataFixtures\DefaultData;

use App\Entity\Role;
use Doctrine\Persistence\ObjectManager;

class RoleFixture extends AbstractDefaultDataFixture
{
    public const ADMIN_REFERENCE = 'admin';
    public const JUDGEHOST_REFERENCE = 'judgehost';

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        // Mapping from role to description
        $roles = [
            'admin'             => 'Administrative User',
            'jury'              => 'Jury User',
            'team'              => 'Team Member',
            'balloon'           => 'Balloon runner',
            'judgehost'         => '(Internal/System) Judgehost',
            'api_reader'        => 'API reader',
            'api_writer'        => 'API writer',
            'api_source_reader' => 'Source code reader',
        ];
        foreach ($roles as $roleName => $description) {
            if (!($role = $manager->getRepository(Role::class)->findOneBy(['dj_role' => $roleName]))) {
                $role = (new Role())
                    ->setDjRole($roleName)
                    ->setDescription($description);
                $manager->persist($role);
                $manager->flush();
            }
            if ($roleName === 'admin') {
                $this->addReference(static::ADMIN_REFERENCE, $role);
            } elseif ($roleName === 'judgehost') {
                $this->addReference(static::JUDGEHOST_REFERENCE, $role);
            }
        }
    }
}
