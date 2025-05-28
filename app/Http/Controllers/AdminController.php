<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    /**
     * Показывает все карточки в системе
     */
    public function index()
    {
        $cards = Card::with('user')->latest()->get();
        return view('admin.index', compact('cards'));
    }
    
    /**
     * Показывает карточки, ожидающие проверки
     */
    public function pending()
    {
        $cards = Card::with('user')->where('status', 'pending')->latest()->get();
        return view('admin.pending', compact('cards'));
    }
    
    /**
     * Одобряет карточку
     */
    public function approve(Card $card)
    {
        $card->update([
            'status' => 'approved'
        ]);
        
        return back()->with('success', 'Карточка успешно одобрена');
    }
    
    /**
     * Отклоняет карточку
     */
    public function reject(Request $request, Card $card)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);
        
        $card->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);
        
        return back()->with('success', 'Карточка отклонена');
    }
} 
