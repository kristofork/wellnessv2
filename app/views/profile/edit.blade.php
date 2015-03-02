@extends('layouts.lite')

{{ HTML::style('assets/css/jquery.Jcrop.min.css') }}


@section('content')

               @if(Session::has('message'))
            <div id="dash-side-right" class="alert alert-success" style="width:29%; z-index:1;">
                <button type="button" class="close" data-dismiss="alert">x</button>
                <p>{{Session::get('message') }} </p>
            </div>
            @endif
            @if($errors->has())
			<div id="dash-side-right" class="alert alert-error" style="width:29%">
			    <button type="button" class="close" data-dismiss="alert">x</button>
			    <ul>
			    {{ $errors->first('file', '<li>:message</li>') }}

			    </ul>
			</div>
			@endif   

<div class="main-row">
	<div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-8" id="dash-nav">
                <ul class="nav tabs">
                <li class="active"><a href="#picture" data-toggle="tab" data-target="#picture, #picture_tips"><span class="hidden-xs">Picture </span><span class="glyphicon glyphicon-user"></span> </a></li>
                <li><a href="#password" data-toggle="tab" data-target="#password, #password_tips"><span class="hidden-xs">Password </span><span class="glyphicon glyphicon-list-alt"></span> </a></li>
                </ul>
                <!-- Nav tabs -->
            </div>
        </div> <!-- End of Row -->
    </div><!-- End of Container -->
    <!-- Start of Main Container -->
	<div class="col-md-8 user_edituser tab-content" style="margin-top:15px;">
		<div class="tab-pane active fluid-container" id="picture">
		{{HTML::image(Auth::user()->pic, Auth::user()->userfirst, array('id'=>'profile', 'class'=> 'img-rounded'));}}

			{{ Form::open(array('url' => 'previewpic', 'id'=>'updatepicform','method' => 'post'))}}
			  <fieldset id="picFormBtn">

				<span class="btn btn-success fileinput-button">
				    
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
			{{ Form::close()}}
		</div><!-- End of Picture Tab -->
		<div class="tab-pane fluid-container" id="password">
			{{ Form::open(array('action' => 'UserController@updatePassword'))}}
			    <div class="form-group col-sm-offset-3 col-sm-6">
			    	<label for="password">New Password</label>
				    <input type="password" name="password" class="form-control" placeholder="New Password">
				</div>
		    	<div class="form-group col-sm-offset-3 col-sm-6">
		    		<label for="password_confirmation">Confirm Password</label>
				    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
				</div>
			    <div class="form-group col-sm-offset-3 col-sm-6">
				    <input class="btn btn-primary btn-sm btn-block" type="submit" value="Reset Password">
				</div>
			        @if(Session::has('status'))
		            <p>{{ Session::get('status') }}</p>
		        @endif

		        @if(Session::has('error'))
		            <p>{{ Session::get('error') }}</p>
		        @endif
			{{ Form::close() }}
		</div>
	</div> <!-- End of Main Container-->
        <!-- Start of Sidebar Right -->
    <div id="dash-side-right" class="hidden-sm hidden-xs tab-content">

        <div class="sidebar-right tab-pane active" id="picture_tips">

            <h4 id="sidebar-heading">Tips</h4>
            <div class="sidebar-padding">
            	<ul>
            		<li>All images must be under 1MB in size</li>
            		<li>Images are resized on selection</li>
            		<li>Try to use a 1:1 picture</li>
            	</ul>
            </div>
                <div style="clear: both"></div> 
        </div>
        <div class="sidebar-right tab-pane" id="password_tips">

            <h4 id="sidebar-heading">Tips</h4>
            <div class="sidebar-padding">
            	<ul>
            		<li>Passwords must be at least 6 characters.</li>
            	</ul>
            </div>
                <div style="clear: both"></div> 
        </div>

    </div>
    <!-- End of Sidebar Right-->
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