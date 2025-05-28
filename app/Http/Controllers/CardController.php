<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the cards.
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        $cards = $user->cards()->latest()->get();
        
        return view('cards.index', compact('cards'));
    }

    /**
     * Show the form for creating a new card.
     */
    public function create()
    {
        return view('cards.create');
    }

    /**
     * Store a newly created card in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'type' => 'required|in:share,want',
            'publisher' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1800|max:' . date('Y'),
            'binding' => 'nullable|in:hard,soft',
            'condition' => 'nullable|in:perfect,normal,needs_attention,table_prop',
        ]);

        $card = new Card($validated);
        $card->user_id = Auth::id();
        $card->status = 'pending';
        $card->save();

        return redirect()->route('cards.index')->with('success', 'Карточка успешно создана и отправлена на модерацию.');
    }

    /**
     * Remove the specified card from storage.
     */
    public function destroy(Card $card)
    {
        if ($card->user_id !== Auth::id()) {
            return redirect()->route('cards.index')->with('error', 'Вы не можете удалить эту карточку.');
        }

        $card->delete();
        return redirect()->route('cards.index')->with('success', 'Карточка успешно удалена.');
    }
    
    /**
     * Approve a card.
     */
    public function approve(Card $card)
    {
        // Проверка прав (в реальном приложении здесь нужна более сложная проверка)
        // Для демонстрации просто проверяем, является ли пользователь владельцем карточки
        if ($card->user_id !== Auth::id()) {
            return redirect()->route('cards.index')->with('error', 'У вас нет прав на выполнение этого действия.');
        }
        
        $card->status = 'approved';
        $card->save();
        
        return back()->with('success', 'Карточка успешно одобрена.');
    }
    
    /**
     * Reject a card.
     */
    public function reject(Request $request, Card $card)
    {
        // Проверка прав (в реальном приложении здесь нужна более сложная проверка)
        // Для демонстрации просто проверяем, является ли пользователь владельцем карточки
        if ($card->user_id !== Auth::id()) {
            return redirect()->route('cards.index')->with('error', 'У вас нет прав на выполнение этого действия.');
        }
        
        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);
        
        $card->status = 'rejected';
        $card->rejection_reason = $request->rejection_reason;
        $card->save();
        
        return back()->with('success', 'Карточка отклонена.');
    }
} 
