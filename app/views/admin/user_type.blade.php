        @foreach($items as $item)
          <li style="display:inline-block; width:100%;">
            {{$item->last_name}}, {{$item->first_name}}
            

            {{ Form::open(array('url' => 'admin/delete/' . $item->id)) }}
              {{ Form::hidden('_method', 'DELETE') }}
              {{ Form::submit('Delete', array('class' => 'btn btn-warning btn-sm pull-right', 'onclick'=> 'if(!confirm("Are you sure to delete this item?")){return false;};')) }}
            {{ Form::close() }}
            <a href="admin/{{$item->id}}/edit" class="btn btn-default btn-sm pull-right" role="button">Edit <span class="glyphicon glyphicon-cog"></span></a>
            
            <a href="/admin/password/{{$item->id}}" class="btn btn-default btn-sm pull-right" role="button">Reset Password <span class="glyphicon glyphicon-off"></span></a>
          </li>
            <hr class="activityHR" />
        @endforeach

<?php echo $items->appends(Input::except('page'))->links(); ?>
