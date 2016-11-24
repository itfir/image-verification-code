<?php
namespace Fir\ImageVerificationCode;

class Facades extends Illuminate\Support\Facades\Facade{

    protected static function getFacadeAccessor(){
        return 'Fir\ImageVerificationCode';
    }

}