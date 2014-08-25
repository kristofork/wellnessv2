        @foreach($items as $item)
          <li>
            {{$item->last_name}}, {{$item->first_name}} 
            <a href="#" class="btn btn-default btn-sm pull-right" role="button">Delete <span class="glyphicon glyphicon-remove"></span></a>
            <a href="admin/{{$item->id}}/edit" class="btn btn-default btn-sm pull-right" role="button">Edit <span class="glyphicon glyphicon-cog"></span></a>
            <a href="#" class="btn btn-default btn-sm pull-right" role="button">View <span class="glyphicon glyphicon-eye-open"></span></a>
          </li>
            <hr class="activityHR" />
        @endforeach

<?php echo $items->appends(Input::except('page'))->links(); ?>
