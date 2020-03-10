<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

use App\Board;
use App\Group;
use App\Card;


class Group Extends Model {
    //
    protected $fillable = ['name',  'group_id','board_id', 'trello_id'];

    public static function syncGroups(){

        $boards = Board::all()->toArray();
        
        foreach($boards as $board){

            $groups = Curl::getItem($board['trello_id'], 'lists');
            
            foreach($groups as $group){
                if(!Group::where('name', $group->name)->first()){
                    $board = Board::where('trello_id' , $group->idBoard)->first()->toArray();
                    
                    $board_id = $board['id'];
                    $data = [
                        'name' => $group->name,
                        'board_id' => $board_id,
                        'trello_id' => $group->id
                    ];

                    $validated = Validator::make($data, [
                        'name' => 'required',
                        'board_id' => 'required',
                        'trello_id' => 'required'
                    ])->validate();
                    Group::create($validated);
                }
            }
        }            
    }

    public function groupsBoard(){
        return $this->belongsTo(Board::class);
    }

    public function groupsCards(){
        return $this->hasMany(Card::class);
    }
}
