@extends('layouts.admin.adminlayout')

@section('header_scripts')
<link rel="stylesheet" type="text/css" href="{{CSS}}select2.css">
@stop

@section('content')
<div id="page-wrapper" ng-controller="angTopicsController">
			<div class="container-fluid">
				<!-- Page Heading -->
				<div class="row">
					<div class="col-lg-12">
						<ol class="breadcrumb">
							<li><a href="{{PREFIX}}"><i class="mdi mdi-home"></i></a> </li>
							<li><a href="{{URL_SETTINGS_LIST}}">{{ getPhrase('settings')}}</a> </li>
							<li><a href="{{URL_SETTINGS_VIEW.$record->slug}}">{{ $record->title }}</a> </li>
							<li class="active">{{isset($title) ? $title : ''}}</li>
						</ol>
					</div>
				</div>
					@include('errors.errors')
				<!-- /.row -->
				<?php $field_types = array(
						    '' => 'Select Type',
						    'text' => 'Text',
						    'number' => 'Number',
						    'email' => 'Email',
                            'password' => 'Password',
                            'select' => 'Select',
                            'checkbox' => 'Checkbox',
                            'file' => 'Image(.png/.jpeg/.jpg)',
                            'textarea' => 'Textarea',
                            ); ?>

			 <div class="panel panel-custom col-lg-8 col-lg-offset-2">
					<div class="panel-heading">
						<div class="pull-right messages-buttons">
							<a href="{{URL_SETTINGS_VIEW.$record->slug}}" class="btn  btn-primary button" >{{ getPhrase('list')}}</a>
						</div>
					<h1>{{ $title }}  </h1>
					</div>
					<div class="panel-body" ng-controller="angTopicsController">
					<?php $button_name = getPhrase('create'); ?>
					{!! Form::open(array('url' => URL_SETTINGS_ADD_SUBSETTINGS.$record->slug, 'method' => 'POST', 
						'name'=>'formSettings ', 'files'=>'true')) !!}
				 		

					 <fieldset class="form-group">
						
						{{ Form::label('key', getphrase('key')) }}
						<span class="text-red">*</span>
						{{ Form::text('key', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('setting_key'),
					
						 ))}}
					
					</fieldset>


					 <fieldset class="form-group">
						
						{{ Form::label('tool_tip', getphrase('tool_tip')) }}
						<span class="text-red">*</span>
						{{ Form::text('tool_tip', $value = null , $attributes = array('class'=>'form-control', 'placeholder' => getPhrase('tool_tip'),
					
						 ))}}
					
					</fieldset>
					
					 <fieldset class="form-group">
						{{ Form::label('type', getphrase('type')) }}
						<span class="text-red">*</span>
						{{Form::select('type',$field_types, null, ['class'=>'form-control', 
						'ng-model' => 'field_type' ])}}
					</fieldset>
				 
					 <fieldset 
					 ng-if="field_type=='text' || field_type=='password' || field_type=='number' || field_type=='email'||  field_type=='file' "
					 class="form-group" >
					 {{ Form::label('type', getphrase('type')) }}
					
					 <input 
					 		type="@{{field_type}}" 
					 		class="form-control" 
					 		name="value" 
					 		required="true" 
					 		ng-model='value'
					 		
					 >
					</fieldset>
					 <fieldset 
					 ng-if="field_type=='checkbox' " class="form-group" >
					 {{ Form::label('type', getphrase('type')) }}
					
					 <input 
					 		type="checkbox" 
							data-toggle="toggle" 
							data-onstyle="success" 
							data-offstyle="default"

					 		class="form-control" 
					 		name="value" 
					 		value="1" 
					 		required="true" 
					 		ng-model='value'
					 		style="display:block;"
					 		checked
					 >
					</fieldset>

					<fieldset 
					 ng-if="field_type=='select'"
					 class="form-group" >

					 {{ Form::label('total_options', getphrase('total_options')) }}
					
						 <input 
					 		type="number" 
					 		class="form-control" 
					 		name="total_options" 
					 		min="1"
					 		required="true" 
					 		ng-model='obj.total_options'
					 		ng-change="intilizeOptions(obj.total_options)"
					 >
					</fieldset>
					

					 <fieldset 
					 ng-if="field_type=='textarea'" class="form-group" >
					 {{ Form::label('description', getphrase('description')) }}
					
					<textarea name="value" class="form-control ckeditor" ng-model='value' rows="5" ></textarea>
					 
					</fieldset>

				{{-- 	<fieldset class="form-group col-md-4"  ng-if="field_type=='checkbox'" class="form-group">
						<label class="checkbox-inline" >
							<input type="checkbox" data-toggle="toggle" name="" data-onstyle="success" data-offstyle="default" > aaa
						</label>
					</fieldset> --}}



					 <div class="row" data-ng-repeat="option in options">
					 	<div class="col-md-12">
						
					<fieldset class="form-group col-md-4" >
						{{ Form::label('option_value', getphrase('option_value') ) }} @{{option}}
							<input 
					 		type="text" 
					 		class="form-control" 
					 		name="option_value[]" 
					 		required="true" >
					</fieldset>
					<fieldset class="form-group col-md-4" >
						{{ Form::label('option_text', getphrase('option_text') ) }} @{{option}}
							<input 
					 		type="text" 
					 		class="form-control" 
					 		name="option_text[]" 
					 		required="true" >
					</fieldset>
					<fieldset class="form-group col-md-4" >
					
                            <input type="radio" name="value" value="@{{option-1}}" id="radio@{{option}}" >
                            <label for="radio@{{option}}"> <span class="fa-stack radio-button"> <i class="mdi mdi-check active"></i> </span> {{getPhrase('make_default')}} </label>
                    
					</fieldset>


			

						</div>

					 </div>
					 


					
					 		<div class="buttons text-center">
							<button class="btn btn-lg btn-success button" 
							>{{ $button_name }}</button>
						</div>
					 
					{!! Form::close() !!}
					 

					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
		<!-- /#page-wrapper -->
@stop
@section('footer_scripts')
	
	@include('mastersettings.settings.scripts.js-scripts' );
	@include('common.validations', array('isLoaded'=>true));
	 {{-- @include('common.editor'); --}}
	  <script src="{{JS}}bootstrap-toggle.min.js"></script>
@stop
 