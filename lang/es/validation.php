<?php

// Mensajes de validación en español (solo las reglas usadas en el proyecto).
return [
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser un correo electrónico válido.',
    'string' => 'El campo :attribute debe ser texto.',
    'max' => [
        'string' => 'El campo :attribute no debe superar los :max caracteres.',
    ],
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'unique' => 'El valor de :attribute ya está registrado.',
    'in' => 'El valor seleccionado en :attribute no es válido.',

    'attributes' => [
        'nombre' => 'nombre',
        'codigo' => 'código',
        'tipo' => 'tipo',
        'descripcion' => 'descripción',
        'estado' => 'estado',
        'motivo' => 'motivo',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
    ],
];
