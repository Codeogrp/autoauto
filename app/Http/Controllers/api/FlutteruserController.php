<?php
namespace App\Http\Controllers\Flutter;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\Campaign;


class FlutteruserController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        event(new Registered($user));
        Auth::login($user);
        $token = $user->createToken('MySecret')->accessToken;
        return response()->json(['token' => $token], 200);
    }
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email|max:191',
            'password'=>'required|string'
        ]);

        $user = User::where('email',$credentials['email'])->first();
        
        if (!$user|| !Hash::check($credentials['password'],$user->password)) {
            return response()->json(['error' => 'UnAuthorized'], 401);
        }
        else {
            $token = $user->createToken('MySecret')->accessToken;
            return response()->json(['user'=>$user,'token'=>$token,], 200);
        }
    }

    
    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }

    public function indexcamp()
    {
        // $campaigns = auth()->user()->campaigns;
        $campaigns = Campaign::latest(); 
        // $campaigns = auth()->user()->campaigns;
 
        return response()->json(  $campaigns );
    }
 
    public function showcamp($id)
    {
        $campaign = Campaign::find($id);

        // $campaign = auth()->user()->campaigns()->find($id);

        if (!$campaign) {
            return response()->json('sorry', 400);
        }
 
        return response()->json( [$campaign->toArray()] , 200);
    }
}