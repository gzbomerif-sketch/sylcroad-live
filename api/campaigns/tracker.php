<?php
/**
 * Campaign Tracker API Endpoint
 * Returns campaign data for the CrownCoins Master Tracker dashboard
 */

require_once '../config.php';

// Verify authentication (optional - remove if public)
// $token = getBearerToken();
// $userData = verifyJWT($token);
// if (!$userData) {
//     sendError('Unauthorized', 401);
// }

// Sample campaign data (in production, this would come from a database)
$campaignData = [
    'success' => true,
    'data' => [
        'tracker' => [
            'name' => 'CrownCoins Master Tracker',
            'organization' => 'Streamline Music Group',
            'status' => 'ENABLED',
            'total_budget' => 150000,
            'total_spend' => 100000,
            'spend_committed' => 0,
            'currency' => 'USD'
        ],
        'activations' => [
            [
                'id' => 1,
                'name' => 'CrownCoins Open Creative',
                'goal' => '167 Million Views',
                'goal_value' => 167000000,
                'brand' => [
                    'name' => 'CrownCoins Casino',
                    'type' => 'Gaming & Entertainment',
                    'icon' => '🎰'
                ],
                'budget' => 50000,
                'spent' => 50000,
                'progress' => 100,
                'status' => 'ACTIVE',
                'segments' => [
                    [
                        'id' => 'IG-AUD-001234567',
                        'name' => 'Original Audio Mix - Casino Theme',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234568',
                        'name' => 'Remix - Lucky Spin Vibes',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234569',
                        'name' => 'Jackpot Winner Sound Effect',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234570',
                        'name' => 'Vegas Nights - Extended Mix',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234571',
                        'name' => 'Crown Coins Theme - Radio Edit',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ]
                ],
                'segment_count' => '200+ Assets'
            ],
            [
                'id' => 2,
                'name' => 'CrownCoins Open Creative',
                'goal' => '400 Million Views',
                'goal_value' => 400000000,
                'brand' => [
                    'name' => 'CrownCoins Casino',
                    'type' => 'Gaming & Entertainment',
                    'icon' => '🎰'
                ],
                'budget' => 50000,
                'spent' => 50000,
                'progress' => 100,
                'status' => 'ACTIVE',
                'segments' => [
                    [
                        'id' => 'IG-AUD-001234572',
                        'name' => 'High Roller Theme - Club Mix',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234573',
                        'name' => 'Slot Machine Sound Design',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234574',
                        'name' => 'Winner Celebration Audio',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234575',
                        'name' => 'Golden Crown - Signature Theme',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ],
                    [
                        'id' => 'IG-AUD-001234576',
                        'name' => 'Casino Floor Ambience Loop',
                        'platform' => 'Instagram',
                        'icon' => '🎵'
                    ]
                ],
                'segment_count' => '200+ Assets'
            ]
        ]
    ]
];

sendResponse($campaignData);
?>
