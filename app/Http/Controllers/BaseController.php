<?php


namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class BaseController extends Controller
{

    public function returnResult($result){
        if(!$result['error']){
            return $this->responseJson(CODE_SUCCESS, null, $result['data']);
        } else {
            return $this->responseJson(CODE_ERROR, $result['message']);
        }
    }
}
