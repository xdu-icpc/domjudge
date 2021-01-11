<?php declare(strict_types=1);

namespace App\DataFixtures\DefaultData;

use App\Entity\Executable;
use App\Entity\ImmutableExecutable;
use App\Service\DOMJudgeService;
use Doctrine\Persistence\ObjectManager;
use ZipArchive;

class ExecutableFixture extends AbstractDefaultDataFixture
{
    /**
     * @var string
     */
    protected $sqlDir;

    /**
     * @var DOMJudgeService
     */
    protected $dj;

    public function __construct(string $sqlDir, DOMJudgeService $dj)
    {
        $this->sqlDir = $sqlDir;
        $this->dj     = $dj;
    }

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            // ID,                description,                                         type
            ['adb',               'adb',                                              'compile'],
            ['awk',               'awk',                                              'compile'],
            ['bash',              'bash',                                             'compile'],
            ['c',                 'c',                                                'compile'],
            ['compare',           'default compare script',                           'compare'],
            ['cpp',               'cpp',                                              'compile'],
            ['csharp',            'csharp',                                           'compile'],
            ['f95',               'f95',                                              'compile'],
            ['float',             'default compare script for floats with prec 1E-7', 'compare'],
            ['hs',                'hs',                                               'compile'],
            ['kt',                'kt',                                               'compile'],
            ['java_javac',        'java_javac',                                       'compile'],
            ['java_javac_detect', 'java_javac_detect',                                'compile'],
            ['js',                'js',                                               'compile'],
            ['lua',               'lua',                                              'compile'],
            ['pas',               'pas',                                              'compile'],
            ['pl',                'pl',                                               'compile'],
            ['plg',               'plg',                                              'compile'],
            ['py2',               'py2',                                              'compile'],
            ['py3',               'py3',                                              'compile'],
            ['r',                 'r',                                                'compile'],
            ['rb',                'rb',                                               'compile'],
            ['run',               'default run script',                               'run'],
            ['scala',             'scala',                                            'compile'],
            ['sh',                'sh',                                               'compile'],
            ['swift',             'swift',                                            'compile'],
        ];

        foreach ($data as $item) {
            // Note: we only create the executable if it doesn't exist yet.
            // If it does, we will not update the data
            if (!($executable = $manager->getRepository(Executable::class)->find($item[0]))) {
                $file = sprintf('%s/files/defaultdata/%s.zip',
                    $this->sqlDir, $item[0]
                );
                $executable = (new Executable())
                    ->setExecid($item[0])
                    ->setDescription($item[1])
                    ->setType($item[2])
                    ->setImmutableExecutable($this->createImmutableExecutable($file));
                $manager->persist($executable);
                $manager->flush();
            }
            $this->addReference('executable_' . $executable->getExecid(), $executable);
        }
    }

    private function createImmutableExecutable(string $filename): ImmutableExecutable
    {
        $zip = new ZipArchive();
        $zip->open($filename, ZIPARCHIVE::CHECKCONS);
        return $this->dj->createImmutableExecutable($zip);
    }
}
