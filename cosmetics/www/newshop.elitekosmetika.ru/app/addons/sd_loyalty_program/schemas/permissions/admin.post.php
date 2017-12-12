<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

$schema['loyalty_program'] = array (
    'permissions' => 'loyalty_program',
    'modes' => array(
        'manage' => array(
            'use_company' => true,
        ),
        'update' => array(
            'use_company' => true,
        ),
        'assign' => array(
            'use_company' => true,
        ),
    ),
);

return $schema;