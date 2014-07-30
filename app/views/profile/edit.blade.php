@extends('layouts.master')

{{ HTML::style('assets/css/jquery.Jcrop.min.css') }}


@section('content')
        
@if(Session::has('status_message'))
<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <p>{{Session::get('status_message') }} </p>
</div>
@endif

@if($errors->has())
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">x</button>
    <ul>
    {{ $errors->first('file', '<li>:message</li>') }}

    </ul>
</div>
@endif

<div class="row">
		<div class="col-md-8">

		</div>
		<div class="col-md-4">
        <div class=" sidebar-nav well well-small" id="imageContainer" data-provide="typeahead">
            <ul class="nav nav-list">
                <li class="nav-header">Picture</li>
			{{HTML::image(Auth::user()->pic, Auth::user()->userfirst, array('id'=>'profile', 'class'=> 'img-rounded'));}}
            </ul>
				{{ Form::open(array('url' => 'previewpic', 'id'=>'lostpetform','method' => 'post'))}}
				  <fieldset id="picFormBtn">

					<span class="btn btn-success fileinput-button">
					    <i class="icon-picture"></i>
					    <span>Change Profile Picture</span>
					    <!-- The file input field used as target for the file upload widget -->
					    <input id="fileupload" accept="image/*" type="file" name="file">
					</span>

					<!-- The global progress bar -->
					<div id="progress" class="progress" style="margin-top:20px;margin-bottom:20px;">
					    <div class="bar"></div>
					</div>
					<!-- The container for the uploaded files -->
					    <div class="modal fade" id="previewModel">
					    	<div class="modal-dialog">
					    		<div class="modal-content">
								    <div class="modal-header">
								    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								    <h3>Preview / Crop Picture</h3>
								    </div>
								    <div class="modal-body" id="files">
								    </div>
								    <div class="modal-footer">
								    <a href="#" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</a>
								    <button type="submit" class="btn btn-large"><i class="icon-eye"></i> Update Picture</button>
								    </div>
								</div>
							</div>
					    </div>


					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />
				  </fieldset>
				{{ Form::close();}}
			</div>
		</div>	
		</div>
</div>

{{ HTML::script('assets/js/upload/spin.min.js')}}
{{ HTML::script('assets/js/upload/jquery.ui.widget.js')}}
{{ HTML::script('assets/js/upload/jquery.iframe-transport.js')}}
{{ HTML::script('assets/js/upload/jquery.fileupload.js')}}
{{ HTML::script('assets/js/upload/jquery.fileupload-process.js')}}
{{ HTML::script('assets/js/upload/jquery.fileupload-validate.js')}}
{{ HTML::script('assets/js/upload/jquery.Jcrop.min.js')}}
{{ HTML::script('assets/js/upload/upload-crop.js') }}

@stop