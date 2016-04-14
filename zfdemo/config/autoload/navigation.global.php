<?php

return array(
    'navigation' => array(
        'default' => array(
            array(
                'label' => 'Home',
                'route' => 'application'
            ),
            array(
                'label' => 'Login',
                'route' => 'training/verify'
            )
        ),
        'member' => array(
//			array(
//				'label' => 'Home',
//				'route' => 'application',
//			),
            array(
                'label' => 'Member Manager',
                'route' => 'training/member',
                'resource' => 'training:user',
                'privilege' => 'index',
                'role' => 'member',
                    'pages' => array(
//					array(
//						'label' => 'List Member',
//						'route' => 'training/member',
//						'action' => 'index',
//					),
                        array(
                            'label' => 'Add A Member',
                            'route' => 'training/member',
                            'action' => 'add',
                            'privilege' => 'add',
                            'resource' => 'training:user',
                            'role' => 'member',
                        ),
                        array(
                            'label' => 'Edit A Member',
                            'route' => 'training/member',
                            'action' => 'edit',
                            'privilege' => 'edit',
                            'resource' => 'training:user',
                            'role' => 'member',
                        ),
                        array(
                            'label' => 'Del A Member',
                            'route' => 'training/member',
                            'action' => 'del',
                            'privilege' => 'del',
                            'resource' => 'training:user',
                            'role' => 'member',
                        ),
                    ),
            ),
        ),
    ),
);
