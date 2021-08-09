<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

     //결제 시스템을 사용해야하는데, csrf보호를 하게되면, 연동이 힘들어진다. 
     //그럴 경우에는 CSRF보호에서 제외해줘야 하는 경우에
     //$except에 URL을 추가해두면 된다. 
    protected $except = [
        //
    ];
}
