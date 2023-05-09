<?php
namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: Phieule
 * Date: 11/15/2019
 * Time: 9:14 PM
 */

trait ResponseFormatTrait
{
    private $responseData = array(
        'ErrorCode' => 1,
        'ErrorDescription' => 'Chưa thiết lập response.',
        'Data' => array()
    );

    /**
     * Set response data
     *
     * @param int $errorCode
     * @param string $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function responseJson($errorCode, $message = null, $data = null)
    {
        $this->responseData['Data']             = $errorCode == CODE_SUCCESS ? $data : null;
        $this->responseData['ErrorCode']        = $errorCode;
        $this->responseData['ErrorDescription'] = $message ?: 'Xử lý thành công.';

        if ($errorCode != CODE_SUCCESS && $data != null) {
            $this->responseData['ErrorData'] = $data;
        }

        return response()->json($this->responseData);
    }
}
