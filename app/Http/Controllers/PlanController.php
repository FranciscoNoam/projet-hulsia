<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\Plan;
use App\Models\FonctionGenerique;

class PlanController extends Controller
{
    public function __construct(){
            $this->fonct = new FonctionGenerique();
    }

    public function index()
    {
            $plans = $this->fonct->findAll("plans");
            return view('plans.index', compact('plans'));
    }
}
