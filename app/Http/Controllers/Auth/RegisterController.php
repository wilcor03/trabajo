<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'api_token'     => Str::random(60),
            'profileType'   => $data['profileType']
        ]);    
        
    }

    public function socialRegister(Request $r){
      dd($r->all());
    }

    public function register(Request $r){              
        if($r->has('social_red')){          
          $emailValidation = ['required', 'string', 'email', 'max:100'];
        } else {          
          $emailValidation = ['required', 'string', 'email', 'max:100', 'unique:users'];
        }

        $r->validate([
            'name'        => ['required', 'string', 'max:100'],
            'email'       => $emailValidation,
            'password'    => ['required', 'string', 'min:8'],
            'profileType' => 'nullable|in:2,3'
        ]);
        //dd(bcrypt($r->password));
        
        if($r->has('social_red') && $r->social_red != ""){          
          $user = User::updateOrCreate(
            ['email' => $r->email],
            [
              'email'       => $r->email,
              'name'        => $r->name,
              'password'    => bcrypt($r->password),
              'social_red'  => $r->social_red
            ]
          );
          
          if($user){
            return response()->json($user, 200);    
          }
          
        }

        //WHEN REGISTER IS DIRECTLY

        $user = new User;//::firstOrNew(['email' => request()->email]);
        $user->name          = $r->name; 
        $user->email         = $r->email;
        $user->password      = bcrypt($r->password);
        //$user->api_token     = Str::random(60);
        $user->profileType   = $r->profileType;
        if($user->save()){
            return response()->json($user, 200);    
        }

        return response()->json(['success' => false], 404);    
        

        /*$http = new Client(['verify' => url('oauth/token')]);
        $response = $http->post(url('oauth/token'), [
          'form_params' => [
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'BFRujvtVCttROxvJqjfyczjtHfNQxxhrkMPlPNrV',
            'username' => 'wilcor06@gmail.com',
            'password' => '03306080',
            'scope' => '',
          ],
        ]);*/

        //return json_decode((string) $response->getBody(), true);

    }
}
