<?php

declare(strict_types=1);

namespace App\Controller\Backend;

use App\Controller\AbstractController;
use App\Model\Admin;
use App\Request\Backend\LoginRequest;
use Hyperf\Di\Annotation\Inject;
use Phper666\JWTAuth\JWT;

class AuthController extends AbstractController
{   

    /**
     *
     * @Inject
     * @var JWT
     */
    protected $jwt;

    /**
     * Login
     *
     * @param LoginRequest $request
     * @return void
     */
    public function login(LoginRequest $request)
    {

        $email = $request->input('email');
        $password = $request->input('password');

        $admin = Admin::query()            
            ->where('email', $email)            
            ->first();

        if (!$admin || $admin->password != md5($password.$admin->salt)) {
            return [
                'code' => 0,
                'msg' => 'Email or password do not match',
                'data' => (object)[],
            ];
        }        

        $token = $this->jwt->setScene('default')->getToken([
            'uid' => $admin->admin_id,
            'email' => $admin->email,
        ]);
        
        return [
            'code' => 1,
            'msg' => 'success',
            'data' => [
                'token' => $token,
                'expire' => $this->jwt->getTTL(),
            ],
        ]; 
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        $this->jwt->logout();

        return [
            'code' => 1,
            'msg' => 'success',
            'data' => (object)[],
        ];
    }


    public function info() 
    {        
        $jwtData = $this->jwt->setScene('default')->getParserData();
        if (!$jwtData) {
            return [
                'code' => 0,
                'msg' => 'Token authentication error',
                'data' => (object)[],
            ]; 
        }

        $admin = Admin::find($jwtData['uid']);

        return [
            'code' => 1,
            'msg' => 'success',
            'data' => $admin,
        ];
    }
}
