<?php
/**
 * Created by PhpStorm.
 * User: pathao
 * Date: 10/1/18
 * Time: 4:33 PM
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;

class TestController extends Controller
{

    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function test(Request $request){

        //return json_encode($this->jwt->parseToken()->getPayload()->get('client_id'));



        try {
            $this->jwt->setToken($this->jwt->getToken());
            if (! $user = $this->jwt->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
            return json_encode($user);


        } catch (\Exception $e){

            return $e->getMessage();
        }

        // the token is valid and we have found the user via the sub claim
        //$payload = $this->jwt->parseToken()->getPayload();
        //return response()->json($payload->get('client_id'));

    }

    public function testJWT(Request $request){

        return "Happy coding ".$request['client_id'];
    }

}