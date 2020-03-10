<?php

namespace App;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;

use App\Curl;
use App\Board;
use App\Group;

class Card extends Model
{
    //
    protected $fillable = ['name','group_id','trello_id'];


    public static function syncCards(){

        $boards = Board::all()->toArray();

        $groups = Group::all()->toArray();
        
        foreach($boards as $board){
            $cards = Curl::getItem($board['trello_id'], 'cards');
            
            foreach($cards as $card){
                if (!Card::where('name', $card->name)->first()){
                    $data = [
                        'name' => $card->name,
                        'trello_id' => $card->id,
                        'group_id' => $board['id']
                    ];
                    $validated = Validator::make($data, [
                        'name' => 'required',
                        'trello_id' => 'required',
                        'group_id' => 'required'
                    ])->validate();


                    Card::create($validated);
                }
            }
        }       
    } 

    public function group(){
        $this->belongsTo(Group::class);
    }
}
