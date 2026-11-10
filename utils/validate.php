<?php

function validateName(string $data, string $label): string|bool
{
    if (mb_strlen($data, 'UTF-8') < 3) {
        return "Le $label doit contenir au moins 3 caractères.";
    }
    return $message="";
}

function validateEmail(string $data): string|bool
{
    if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
        return "Le format de l'email n'est pas conforme !";
    }
    return $message="";
}

function validatePassword(string $data): string|bool
{
    if (!preg_match('/[A-Z]/', $data)) {
        return "Le mot de passe doit contenir au moins une majuscule !";
    }
    if (!preg_match('/[a-z]/', $data)) {
        return "Le mot de passe doit contenir au moins une minuscule !";
    }
    if (!preg_match('/\d/', $data)) {
        return "Le mot de passe doit contenir au moins un chiffre !";
    }
    return $message="";
}