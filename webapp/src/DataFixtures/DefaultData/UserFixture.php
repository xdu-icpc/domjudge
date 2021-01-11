<?php declare(strict_types=1);

namespace App\DataFixtures\DefaultData;

use App\Entity\User;
use App\Service\DOMJudgeService;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends AbstractDefaultDataFixture implements DependentFixtureInterface
{
    /**
     * @var DOMJudgeService
     */
    protected $dj;

    public function __construct(DOMJudgeService $dj)
    {
        $this->dj = $dj;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        if (!($adminuser = $manager->getRepository(User::class)->findOneBy(['username' => 'admin']))) {
            $adminPasswordFile      = sprintf(
                '%s/%s',
                $this->dj->getDomjudgeEtcDir(),
                'initial_admin_password.secret'
            );
            $encryptedAdminPassword = password_hash(
                trim(file_get_contents($adminPasswordFile)),
                PASSWORD_BCRYPT);

            $adminuser = (new User())
                ->setUsername('admin')
                ->setName('Administrator')
                ->setPassword($encryptedAdminPassword)
                ->addUserRole($this->getReference(RoleFixture::ADMIN_REFERENCE));
            $manager->persist($adminuser);
        }

        if (!($judgehostUser = $manager->getRepository(User::class)->findOneBy(['username' => 'judgehost']))) {
            $restapiCredentialsFile   = sprintf(
                '%s/%s',
                $this->dj->getDomjudgeEtcDir(),
                'restapi.secret'
            );
            $restapiPassword          = exec(
                sprintf(
                    'grep -v ^# %s | cut -f4',
                    escapeshellarg($restapiCredentialsFile)
                )
            );
            $encryptedRestapiPassword = password_hash(
                $restapiPassword, PASSWORD_BCRYPT
            );

            $judgehostUser = (new User())
                ->setUsername('judgehost')
                ->setName('User for judgedaemons')
                ->setPassword($encryptedRestapiPassword)
                ->addUserRole($this->getReference(RoleFixture::JUDGEHOST_REFERENCE));
            $manager->persist($judgehostUser);
        }

        $manager->flush();
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [RoleFixture::class];
    }
}
