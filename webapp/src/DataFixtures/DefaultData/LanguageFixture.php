<?php declare(strict_types=1);

namespace App\DataFixtures\DefaultData;

use App\Entity\Executable;
use App\Entity\Language;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LanguageFixture extends AbstractDefaultDataFixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        $data = [
            // ID,     external ID,   name,         extensions,    require entry point, entry point,  allow,  allow,  time factor,  compile script
            //                                                                          description   submit  judge   factor
            ['adb',    'ada',        'Ada',         ['adb', 'ads'],              false, null,         false,  true,   1,            'adb'],
            ['awk',    'awk',        'AWK',         ['awk'],                     false, null,         false,  true,   1,            'awk'],
            ['bash',   'bash',       'Bash shell',  ['bash'],                    false, 'Main file',  false,  true,   1,            'bash'],
            ['c',      'c',          'C',           ['c'],                       false, null,         true,   true,   1,            'c'],
            ['cpp',    'cpp',        'C++',         ['cpp', 'cc', 'cxx', 'c++'], false, null,         true,   true,   1,            'cpp'],
            ['csharp', 'csharp',     'C#',          ['csharp', 'cs'],            false, null,         false,  true,   1,            'csharp'],
            ['f95',    'f95',        'Fortran',     ['f95', 'f90'],              false, null,         false,  true,   1,            'f95'],
            ['hs',     'haskell',    'Haskell',     ['hs', 'lhs'],               false, null,         false,  true,   1,            'hs'],
            ['java',   'java',       'Java',        ['java'],                    false, 'Main class', true,   true,   1,            'java_javac_detect'],
            ['js',     'javascript', 'JavaScript',  ['js'],                      false, 'Main file',  false,  true,   1,            'js'],
            ['lua',    'lua',        'Lua',         ['lua'],                     false, null,         false,  true,   1,            'lua'],
            ['kt',     'kotlin',     'Kotlin',      ['kt'],                      true,  'Main class', false,  true,   1,            'kt'],
            ['pas',    'pascal',     'Pascal',      ['pas', 'p'],                false, 'Main file',  false,  true,   1,            'pas'],
            ['pl',     'pl',         'Perl',        ['pl'],                      false, 'Main file',  false,  true,   1,            'pl'],
            ['plg',    'prolog',     'Prolog',      ['plg'],                     false, 'Main file',  false,  true,   1,            'plg'],
            ['py2',    'python2',    'Python 2',    ['py2', 'py'],               false, 'Main file',  false,  true,   1,            'py2'],
            ['py3',    'python3',    'Python 3',    ['py3'],                     false, 'Main file',  true,   true,   1,            'py3'],
            ['r',      'r',          'R',           ['R'],                       false, 'Main file',  false,  true,   1,            'r'],
            ['rb',     'ruby',       'Ruby',        ['rb'],                      false, 'Main file',  false,  true,   1,            'rb'],
            ['scala',  'scala',      'Scala',       ['scala'],                   false, null,         false,  true,   1,            'scala'],
            ['sh',     'sh',         'POSIX shell', ['sh'],                      false, 'Main file',  false,  true,   1,            'sh'],
            ['swift',  'swift',      'Swift',       ['swift'],                   false, 'Main file',  false,  true,   1,            'swift'],
        ];

        foreach ($data as $item) {
            // Note: we only create the langauge if it doesn't exist yet.
            // If it does, we will not update the data
            if (!$manager->getRepository(Language::class)->find($item[0])) {
                $language = (new Language())
                    ->setLangid($item[0])
                    ->setExternalid($item[1])
                    ->setName($item[2])
                    ->setExtensions($item[3])
                    ->setRequireEntryPoint($item[4])
                    ->setEntryPointDescription($item[5])
                    ->setAllowSubmit($item[6])
                    ->setAllowJudge($item[7])
                    ->setTimeFactor($item[8])
                    ->setCompileExecutable($this->getReference('executable_' . $item[9]));
                $manager->persist($language);
                $manager->flush();
            }
        }
    }

    /**
     * @inheritDoc
     */
    public function getDependencies()
    {
        return [ExecutableFixture::class];
    }
}
