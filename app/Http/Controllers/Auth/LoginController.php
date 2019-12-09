<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Logs;
use Socialite;
use App\Setting;
use App\SocialIdentity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Alert;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    // adicionado para só permitir acesso ao sistema de usuários
    // ativos
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user && ! $user->active) {
            alert()
                ->error('Acesso Negado', 'Este usuário não está ativo no sistema.')
                ->width('40rem');

            return redirect()->back()->with('error', 'O usuário não está ativo no sistema.');
        }

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            // Carrega para a Sessão os valores da tabela de parâmetros
            $this->loadSettings();
            Logs::registerLog('Fez <span class="text-red text-bold">login</span> no sistema');
            toast("<span class='text-blue'>" . $user->name . "</span>, você está logado no sistema.", "success")
                ->autoClose(2500)->toHtml();

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        Logs::registerLog('Fez <span class="text-red text-bold">logout</span> do sistema');

        $this->guard()->logoutCurrentDevice();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }


    public function loadSettings()
    {
        $settings = Setting::all();

        foreach ($settings as $key => $setting) {
            Session::put($setting->name, $setting->content);
        }
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);

        return redirect($this->redirectTo);
    }

    public function findOrCreateUser($providerUser, $provider)
    {
        $account = SocialIdentity::whereProviderName($provider)
            ->whereProviderId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $user = User::whereEmail($providerUser->getEmail())->first();

            if (! $user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                ]);
            }

            $user->identities()->create([
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }
}
