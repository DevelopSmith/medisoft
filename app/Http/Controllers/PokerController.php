<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Poker;

class PokerController extends Controller
{
    function post(Request $request, Poker $poker) {
        $suit = request('suit');
        $value = request('value');
    
        $selected_card = request('selected_card');
        $selected_cards = request('selected_cards');
        $selected_cards_array = [];
    
        if(isset($selected_card)){
            array_push($selected_cards_array, $selected_card);
        }
    
        if(isset($selected_cards)){
            $exploded_cards = explode(',', $selected_cards);
            $selected_cards_array = array_merge($selected_cards_array, $exploded_cards);
        }
    
        $remaining_cards = 52 - count($selected_cards_array);
        $chance = $remaining_cards > 0 ? round(1 / $remaining_cards * 100, 2) : 100;
        $deck = $poker->deck();
    
        return view('home', [
            'suit' => $suit,
            'value' => $value,
            'selected_card' => $selected_card,
            'selected_cards' => implode($selected_cards_array, ','),
            'deck' => implode($deck, ','),
            'chance' => $chance
        ]);
    }
}
