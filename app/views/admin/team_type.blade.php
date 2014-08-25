        @foreach($items as $item)
          <li>
            {{$item->teamName}}
            <button type="button" class="btn btn-danger pull-right">Delete <span class="glyphicon glyphicon-remove"></span></button>
          <button type="button" class="btn btn-default pull-right">Edit <span class="glyphicon glyphicon-cog"></span></button>
            <button type="button" class="btn btn-info pull-right">View <span class="glyphicon glyphicon-eye-open"></span></button>
          </li>
            <hr class="activityHR" />
        @endforeach

<?php echo $items->appends(Input::except('page'))->links(); ?>
