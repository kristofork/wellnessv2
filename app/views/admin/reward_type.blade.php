        @foreach($items as $item)
          <li><strong>{{$item->users->last_name}}, {{$item->users->first_name}}</strong> - Completed <strong>{{$item->name}}</strong> on {{$item->created_at}}</li>       
            <hr class="activityHR" />
        @endforeach

<?php echo $items->appends(Input::except('page'))->links(); ?>
