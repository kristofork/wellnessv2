        @foreach($items as $item)
          <li>
            {{$item->last_name}}, {{$item->first_name}}
            {{ Form::open(array('url' => 'admin/delete/' . $item->id)) }}
              {{ Form::hidden('_method', 'DELETE') }}
              {{ Form::submit('Delete this User', array('class' => 'btn btn-warning btn-sm pull-right', 'onclick'=> 'if(!confirm("Are you sure to delete this item?")){return false;};')) }}
            {{ Form::close() }}
            <a href="admin/{{$item->id}}/edit" class="btn btn-default btn-sm pull-right" role="button">Edit <span class="glyphicon glyphicon-cog"></span></a>
            <a href="#" class="btn btn-default btn-sm pull-right" role="button">View <span class="glyphicon glyphicon-eye-open"></span></a>
          </li>
            <hr class="activityHR" />
        @endforeach

<?php echo $items->appends(Input::except('page'))->links(); ?>
