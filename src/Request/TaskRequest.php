<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;

# couche de validation pour les requêtes.
class TaskRequest extends Request
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'string', 'max:50']
        ];
    }
}