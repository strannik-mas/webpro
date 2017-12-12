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

namespace Tygh\Web\Antibot;

use PhpCaptcha;

class PhpCaptchaDriver implements IAntibotDriver
{
    /**
     * @inheritdoc
     */
    public function isSetUp()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function validateHttpRequest(array $http_request_data)
    {
        $verification_id = !empty($http_request_data['verification_id']) ? $http_request_data['verification_id'] : '';
        $verification_answer = !empty($http_request_data['verification_answer']) ? $http_request_data['verification_answer'] : '';

        return PhpCaptcha::Validate($verification_id, $verification_answer);
    }
}
