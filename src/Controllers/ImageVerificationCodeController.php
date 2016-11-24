<?php
namespace Fir\ImageVerificationCode\Controllers;

use Fir\ImageVerificationCode\ImageVerificationCode;
use Illuminate\Routing\Controller;

class ImageVerificationCodeController extends Controller{

    public function Generate(){
        $ImageVerificationCode = new ImageVerificationCode();
        return response($ImageVerificationCode->Generate())->header('Content-type', 'image/png');
    }

}
