<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

use Illuminate\Support\Facades\Http;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cedula' => ['required', 'numeric', 'unique:users', 'between:0000000000,9999999999999',
                function ($attribute, $value, $fail){
                    if(!$this->validateCedula($value)){
                        $fail("Lo lamentamos, no se encuentra dentro de nuestros registros de cliente actualmente");
                    }
                },
            ],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'lastname' => $input['lastname'],
            'email' => $input['email'],
            'cedula' => $input['cedula'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'password' => Hash::make($input['password']),
        ]);
    }

    private function validateCedula($cedula){
        $identity = Http::acceptJson()->post("http://181.39.128.194:8092/SAN32.WS.Rest.Bitacora/api/ValidarIdentificacion/ValidarIdentificacion", [
            'cedula' => $cedula,
            'empresa' => 'All Padel',
        ]);
        
        $exist = $identity->json()['Response'];

        // var_dump($identity->json()); die;

        if(empty($exist) || $identity->json()['CodigoError'] == '2000'){
            return false;
        }

        if($exist[0]['EXISTE_CLIENTE'] == 0) //&& ($identity->json()['CodigoError'] != "200" && $identity->json()['CodigoError'] != "00"))
        {
            return false;
        }
        
        return true;
    }
}
