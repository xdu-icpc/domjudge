<?php declare(strict_types=1);

namespace App\Tests\Unit\Controller\API;

class GroupControllerTest extends BaseTest
{
    protected $apiEndpoint = 'groups';

    protected $expectedObjects = [
        '2' => [
            'hidden'    => false,
            'icpc_id'   => '2',
            'id'        => '2',
            'name'      => 'Self-Registered',
            'sortorder' => 8,
            'color'     => '#33cc44'
        ],
        '3' => [
            'hidden'    => false,
            'icpc_id'   => '3',
            'id'        => '3',
            'name'      => 'Participants',
            'sortorder' => 0,
            'color'     => null
        ],
        '4' => [
            'hidden'    => false,
            'icpc_id'   => '4',
            'id'        => '4',
            'name'      => 'Observers',
            'sortorder' => 1,
            'color'     => '#ffcc33'
        ]
    ];

    // We test explicitly for groups 1 and 5 here, which are hidden groups and
    // should not be returned for non-admin users.
    protected $expectedAbsent = ['4242', 'nonexistent', '1', '5'];
}
