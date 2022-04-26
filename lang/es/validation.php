<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'El :attribute debe ser aceptado.',
    'active_url' => 'El :attribute no es una URL válida.',
    'after' => 'El :attribute debe ser una fecha posterior a :date.',
    'after_or_equal' => 'El :attribute debe ser una fecha posterior o igual a :date.',
    'alpha' => 'El :attribute sólo debe contener letras.',
    'alpha_dash' => 'El :attribute sólo debe contener letras, números, guiones y guiones bajos.',
    'alpha_num' => 'El :attribute sólo debe contener letras y números.',
    'array' => 'El :attribute debe ser un array.',
    'before' => 'El :attribute debe ser una fecha anterior a :date.',
    'before_or_equal' => 'El :attribute debe ser una fecha anterior o igual a :date.',
    'between' => [
        'numeric' => 'El :attribute debe estar entre :min y :max.',
        'file' => 'El :attribute debe estar entre :min y :max kilobytes.',
        'string' => 'El :attribute debe estar entre :min y :max caracteres.',
        'array' => 'El :attribute debe estar entre :min y :max artículos.',
    ],
    'boolean' => 'El :attribute debe ser verdadero o falso.',
    'confirmed' => 'El :attribute la confirmación no coincide.',
    'date' => 'El :attribute no es una fecha válida.',
    'date_equals' => 'El :attribute debe ser una fecha igual a :date.',
    'date_format' => 'El :attribute no coincide con el formato :format.',
    'different' => 'El :attribute y :other debe ser diferente.',
    'digits' => 'El :attribute debe ser :digits dígitos.',
    'digits_between' => 'El :attribute debe ser entre :min y :max dígitos.',
    'dimensions' => 'El :attribute tiene dimensiones de imagen no válidas.',
    'distinct' => 'El :attribute tiene un valor duplicado.',
    'email' => 'El :attribute debe ser una dirección de correo electrónico válida.',
    'ends_with' => 'El :attribute debe terminar con uno de los following: :values.',
    'exists' => 'El :attribute seleccionado no es válido.',
    'file' => 'El :attribute debe ser un archivo.',
    'filled' => 'El :attribute debe tener un valor.',
    'gt' => [
        'numeric' => 'El :attribute debe ser greater than :value.',
        'file' => 'El :attribute debe ser greater than :value kilobytes.',
        'string' => 'El :attribute debe ser greater than :value characters.',
        'array' => 'El :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'El :attribute debe ser greater than or equal :value.',
        'file' => 'El :attribute debe ser greater than or equal :value kilobytes.',
        'string' => 'El :attribute debe ser greater than or equal :value characters.',
        'array' => 'El :attribute must have :value items or more.',
    ],
    'image' => 'El :attribute debe ser an image.',
    'in' => 'El selected :attribute is invalid.',
    'in_array' => 'El :attribute field does not exist in :other.',
    'integer' => 'El :attribute debe ser an integer.',
    'ip' => 'El :attribute debe ser a valid IP address.',
    'ipv4' => 'El :attribute debe ser a valid IPv4 address.',
    'ipv6' => 'El :attribute debe ser a valid IPv6 address.',
    'json' => 'El :attribute debe ser a valid JSON string.',
    'lt' => [
        'numeric' => 'El :attribute debe ser less than :value.',
        'file' => 'El :attribute debe ser less than :value kilobytes.',
        'string' => 'El :attribute debe ser less than :value characters.',
        'array' => 'El :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'El :attribute debe ser less than or equal :value.',
        'file' => 'El :attribute debe ser less than or equal :value kilobytes.',
        'string' => 'El :attribute debe ser less than or equal :value characters.',
        'array' => 'El :attribute must not have more than :value items.',
    ],
    'max' => [
        'numeric' => 'El :attribute must not be greater than :max.',
        'file' => 'El :attribute must not be greater than :max kilobytes.',
        'string' => 'El :attribute must not be greater than :max characters.',
        'array' => 'El :attribute must not have more than :max items.',
    ],
    'mimes' => 'El :attribute debe ser a file of type: :values.',
    'mimetypes' => 'El :attribute debe ser a file of type: :values.',
    'min' => [
        'numeric' => 'El :attribute debe ser at least :min.',
        'file' => 'El :attribute debe ser at least :min kilobytes.',
        'string' => 'El :attribute debe ser at least :min characters.',
        'array' => 'El :attribute must have at least :min items.',
    ],
    'multiple_of' => 'El :attribute debe ser a multiple of :value.',
    'not_in' => 'El selected :attribute is invalid.',
    'not_regex' => 'El :attribute format is invalid.',
    'numeric' => 'El :attribute debe ser a number.',
    'password' => 'La contraseña es incorrecta.',
    'present' => 'El :attribute field debe ser present.',
    'regex' => 'El :attribute format is invalid.',
    'required' => 'El :attribute es requerido.',
    'required_if' => 'El :attribute field is required when :other is :value.',
    'required_unless' => 'El :attribute field is required unless :other is in :values.',
    'required_with' => 'El :attribute field is required when :values is present.',
    'required_with_all' => 'El :attribute field is required when :values are present.',
    'required_without' => 'El :attribute field is required when :values is not present.',
    'required_without_all' => 'El :attribute field is required when none of :values are present.',
    'prohibited' => 'El :attribute field is prohibited.',
    'prohibited_if' => 'El :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'El :attribute field is prohibited unless :other is in :values.',
    'same' => 'El :attribute and :other must match.',
    'size' => [
        'numeric' => 'El :attribute debe ser :size.',
        'file' => 'El :attribute debe ser :size kilobytes.',
        'string' => 'El :attribute debe ser :size characters.',
        'array' => 'El :attribute must contain :size items.',
    ],
    'starts_with' => 'El :attribute must start with one of the following: :values.',
    'string' => 'El :attribute debe ser una cadena de texto.',
    'timezone' => 'El :attribute debe ser a valid zone.',
    'unique' => 'El :attribute ya se existe dentro de nuestros registros.',
    'uploaded' => 'El :attribute failed to upload.',
    'url' => 'El :attribute format is invalid.',
    'uuid' => 'El :attribute debe ser a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
