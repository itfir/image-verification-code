<?php
namespace Fir\ImageVerificationCode\Facades;

class Facades extends Illuminate\Support\Facades\Facade{

    protected static function getFacadeAccessor(){
        return 'Fir\ImageVerificationCode';
    }

}