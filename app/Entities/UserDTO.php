<?php

namespace App\Entities;

use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class UserDTO extends Data
{
    public function __construct(
        public string $name,
        #[Email]
        public string $email,
        public string $password,
        public bool|Optional $is_admin,
        public string|Optional $api_key,
        public string|Optional $token,
    ){
    }
}
