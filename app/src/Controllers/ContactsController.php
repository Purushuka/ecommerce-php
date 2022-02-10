<?php

namespace App\Controllers;

class ContactsController extends Controller
{
    public function index(): void
    {
        $this->render('contact');
    }
}