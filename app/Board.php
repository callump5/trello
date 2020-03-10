<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Board;
use App\Group;

class Board extends Model
{
    //
    protected $fillable = ['name', 'trello_id'];

    public static function syncBoards(){
        $boards = Curl::getBoards();
        foreach($boards as $board){
            if(! Board::where('name', $board->name)->first()){  
                $data = [
                    'name' => $board->name,
                    'trello_id' => $board->id
                ];
                $validated = Validator::make($data, [
                    'name' => 'required',
                    'trello_id' => 'required',
                ])->validate();
                Board::create($validated);
            }
        }   
    }

    public function groups(){
        return $this->hasMany(Group::class);
    }
}
