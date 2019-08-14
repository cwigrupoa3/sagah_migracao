<?php

namespace App\Helpers;

class DecodeSecParsHelper
{

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    //--------------------------------------------------------------------------------------------------------//

    public static function decodeSecPars($secparams, $sectok)
    {

        if ($secparams == null) {
            return false;
        }

        $tok = md5(getenv('SEC_PARMS_COMMON_KEY').$secparams);
        if ($tok != $sectok) {
            return false;
        }

        $secparams = base64_decode($secparams);

        parse_str($secparams, $params);

        return $params;
    }
}