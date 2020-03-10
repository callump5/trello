@foreach($boards as $board)
<h1>{{$board->name}}</h1>

    @foreach($board->groups as $group)
        <p>{{$group->name}}</p>

            @foreach($group->groupsCards as $card)
                <li>{{$card->name}}</li>
            @endforeach 
    @endforeach


    
@endforeach


<a href="/sync-trello">Sync</a>