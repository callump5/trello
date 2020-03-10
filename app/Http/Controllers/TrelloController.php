<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;
use App\Group;
use App\Card;

class TrelloController extends Controller
{
    //
    public function syncTrello(){
        Board::syncBoards();
        Group::syncGroups();
        Card::syncCards();

        return redirect('/');
    }

    public function index(){
        $boards = Board::all();
        $groups = Group::all();
        $cards = Card::all();


        return view('trello.index', [
            'boards' => $boards,
            'groups' => $groups,
            'cards' => $cards
        ]);
    }
}
