<?php declare(strict_types=1);

namespace App\Tests\Unit\Controller\API;

class ContestControllerTest extends BaseTest
{
    protected $apiEndpoint = 'contests';

    protected $expectedObjects = [
        '2' => [
            'formal_name'                => 'Demo contest',
            'penalty_time'               => 20,
            'start_time'                 => '2020-01-01T11:00:00+00:00',
            'end_time'                   => '2023-01-01T16:00:00+00:00',
            'duration'                   => '26309:00:00.000',
            'scoreboard_freeze_duration' => '1:00:00.000',
            'id'                         => '2',
            'external_id'                => 'demo',
            'name'                       => 'Demo contest',
            'shortname'                  => 'demo',
            'banner'                     => null,
        ],
    ];

    protected $expectedAbsent = ['4242', 'nonexistent'];
}
