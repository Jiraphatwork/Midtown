<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
        @include("$prefix.layout.head")
	</head>
	<!--end::Head-->

	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				<!--begin::Header-->
				<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
					@include("$prefix.layout.head-menu")
				</div>
				<!--end::Header-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

					<!--begin::Sidebar-->
					@include("$prefix.layout.side-menu")
					<!--end::Sidebar-->

					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">
							<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
								<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                                    @include("$prefix.layout.breadcrumbs")
								</div>
							</div>

							<div id="kt_app_content" class="app-content flex-column-fluid">
								<!--begin::Content container-->
								<div id="kt_app_content_container" class="app-container container-xxl">
									<form id="form_submit" method="POST" enctype="multipart/form-data" class="">
									@csrf
										<div class="row">
											<div class="col-md-3 mb-5">
												<div class="card card-flush py-4">
													<div class="card-header">
														<div class="card-title">
															<h2>Status</h2>
														</div>
													
														<div class="card-toolbar">
															<div class="rounded-circle {{Helper::Status($row->isActive)}} w-15px h-15px" id="kt_ecommerce_add_category_status"></div>
														</div>
													</div>
													
													<div class="card-body pt-0">
														<select name="isActive" id="isActive" class="form-select">
															<option value="Y" @if(@$row->isActive == 'Y') selected @endif>Active</option>
															<option value="N" @if(@$row->isActive == 'N') selected @endif>Inactive</option>
														</select>
													</div>
												</div>
											</div>
											<div class="col-md-9">
												<div class="card card-flush py-4">
													<div class="card-header">
														<div class="card-title">
															<h2>General</h2>
														</div>
													</div>
													<div class="card-body pt-0">
	
														<div class="row">
															<div class="col-md-6">
																<label class="required form-label">Role </label>
																<input type="text" id="name" name="name" class="form-control mb-2" placeholder="Role name" value="{{@$row->name}}">
															</div>
														</div>
	
														<div class="row">
															<div class="col-md-12">
																<label class="required form-label">Detail </label>
																<input type="text" id="detail" name="detail" class="form-control mb-2" placeholder="Detail - Role" value="{{@$row->detail}}">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
										<div class="row mt-5">
											<div class="col-md-12">
												<div class="card card-flush py-4">
													<div class="card-header">
														<div class="card-title">
															<h2 class="font-medium text-base mr-auto">
																<i class="fa fa-cog text-danger"></i>  Permission Setting
															</h2>
														</div>
													</div>
													<div class="card-body pt-0">
														<table class="table">
															<thead class="" style="background-color: #e8ecef;">
																<th style="width:5%;" class="text-center text-black">#</th>
																<th style="width:40%;" class="text-left text-black">Menu</th>
																<th style="width:15%;" class="text-left text-black">
																	<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																		<input class="form-check-input" type="checkbox" check="true" check-target=".view" value="1" />
																	</div>
																	View
																</th>
																<th style="width:15%;" class="text-left text-black">
																	<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																		<input class="form-check-input" type="checkbox" check="true" check-target=".create" value="1" />
																	</div>
																	Create
																</th>
																<th style="width:15%;" class="text-left text-black">
																	<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																		<input class="form-check-input" type="checkbox" check="true" check-target=".edit" value="1" />
																	</div>
																	Edit
																</th>
																<th style="width:15%;" class="text-left text-black">
																	<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
																		<input class="form-check-input" type="checkbox" check="true" check-target=".delete" value="1" />
																	</div>
																	Delete
																</th>
															</thead>
															<tbody>
																@if(@$menus)
																	@foreach(@$menus as $index=>$m)
																		@php
																		$second = \App\Models\Backend\MenuModel::where('_id',$m->id)->where('status','on')->get();
																		$role_main = \App\Models\Backend\Role_listModel::where(['role_id'=>$row->id, 'menu_id'=>$m->id])->first();
																		@endphp
																		<tr>
																			<td class="text-center text-black" @if(count(@$second) != null) style="background-color:#d9d6d6;" @endif>{{$index+1}}</td>
																			<td class="text-black" @if(count(@$second) != null) colspan="5" style="background-color:#d9d6d6;" @endif>{{$m->name}} <input name="menu_id[]" value="{{$m->id}}" hidden></td>

																			@if(count(@$second) == null)
																			<td>
																				<div class="form-check form-check-sm form-check-custom form-check-solid">
																					<input class="form-check-input view" type="checkbox" @if(@$role_main->read == "on") checked @endif name="read_{{$m->id}}" />
																				</div>
																			</td>
																			<td>
																				<div class="form-check form-check-sm form-check-custom form-check-solid">
																					<input class="form-check-input create" type="checkbox" @if(@$role_main->add == "on") checked @endif name="add_{{$m->id}}" />
																				</div>
																			</td>
																			<td>
																				<div class="form-check form-check-sm form-check-custom form-check-solid">
																					<input class="form-check-input edit" type="checkbox" @if(@$role_main->edit == "on") checked @endif name="edit_{{$m->id}}" />
																				</div>
																			</td>
																			<td>
																				<div class="form-check form-check-sm form-check-custom form-check-solid">
																					<input class="form-check-input delete" type="checkbox" @if(@$role_main->delete == "on") checked @endif name="delete_{{$m->id}}" />
																				</div>
																			</td>
																			@endif

																		</tr>
																		@if(count(@$second))
																			@foreach(@$second as $i => $s)
																			@php
																			$role_sub = \App\Models\Backend\Role_listModel::where(['role_id'=>$row->id, 'menu_id'=>$s->id])->first();
																			@endphp
																			<tr>
																				<td class="text-center text-black">{{($index+1).".".$i+1}}</td>
																				<td class="text-black">{{$s->name}}</td>
																				<td>
																					<input name="menu_id[]" value="{{$s->id}}" hidden>
																					<div class="form-check form-check-sm form-check-custom form-check-solid">
																						<input class="form-check-input view" type="checkbox" @if(@$role_sub->read == "on") checked @endif name="read_{{$s->id}}" />
																					</div>
																				</td>
																				<td>
																					<div class="form-check form-check-sm form-check-custom form-check-solid">
																						<input class="form-check-input create" type="checkbox" @if(@$role_sub->add == "on") checked @endif name="add_{{$s->id}}" />
																					</div>
																				</td>
																				<td>
																					<div class="form-check form-check-sm form-check-custom form-check-solid">
																						<input class="form-check-input edit" type="checkbox" @if(@$role_sub->edit == "on") checked @endif name="edit_{{$s->id}}" />
																					</div>
																				</td>
																				<td>
																					<div class="form-check form-check-sm form-check-custom form-check-solid">
																						<input class="form-check-input delete" type="checkbox" @if(@$role_sub->delete == "on") checked @endif name="delete_{{$s->id}}" />
																					</div>
																				</td>
																			</tr>
																			@endforeach
																		@endif
																	@endforeach
																@endif
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>


										<div class="row">
											<div class="col-md-12">
												<div class="d-flex justify-content-end mt-5">
													<a href="{{url("$segment/$folder")}}" id="" class="btn btn-light me-2">Cancel</a>
													<button type="button" id="" onclick="check_add();" class="btn btn-primary" style="background: #1C2842;"><span class="indicator-label">Save Changes</span></button>
												</div>
											</div>
										</div>
									</form>
								</div>
								<!--end::Content container-->
							</div>

						</div>
						<!--end::Content wrapper-->

						<!--begin::Footer-->
						<div id="kt_app_footer" class="app-footer">
							@include("$prefix.layout.footer")
						</div>
						<!--End::Footer-->
					</div>
					<!--End::Main-->
				</div>
			</div>
		</div>
		
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>
		
		<!--begin::Javascript-->
		@include("$prefix.layout.script")
		<script>
		$('#resetpassword').change(function()
		{
			if($(this).prop("checked") == true)
			{
				$('#password').attr('disabled',false);
				$('#confirm_password').attr('disabled',false);
			}
			else if($(this).prop("checked") == false)
			{
				$('#password').attr('disabled',true);
				$('#confirm_password').attr('disabled',true);
			}
		});    
	
		$('.show_pass').click(function() {
			var password = $('#password').attr('type');
			if (password == "password") {
				$('#password').attr('type', 'text');
			} else {
				$('#password').attr('type', 'password');
			}
		});
	
	
		$('.show_pass_confirm').click(function() {
			var confirm_password = $('#confirm_password').attr('type');
			if (confirm_password == "password") {
				$('#confirm_password').attr('type', 'text');
			} else {
				$('#confirm_password').attr('type', 'password');
			}
		});
	
		function readURL01(input,key) {
			console.log(key);
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#example_image_'+key).attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
	
		function check_add() {
			var formData = new FormData($("#form_submit")[0]);
	
			var username = $('#username').val();
			var password = $('#password').val();
			var confirm_password = $('#confirm_password').val();
			var profile_name = $('#profile_name').val();
	
			if(username == ""){
				toastr.error("Sorry, please complete the information.");
				return false;
			}
			if (password != confirm_password) {
				toastr.error('Please enter the same password.');
				return false;
			}
			if(profile_name.length >= 20){
				toastr.error("Please enter no more than 20 characters.");
				return false;
			}
	
			Swal.fire({
				icon: 'warning',
				title: 'Please press confirm to complete the transaction.',
				showCancelButton: true,
				confirmButtonText: 'Confirm',
				cancelButtonText: `Cancel`,
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						type: 'POST',
						url: "{{"$segment/$folder/edit/$row->id"}}",
						data: formData,
						processData: false,
						contentType: false,
						dataType: 'json',
						success: function(data) {
							if (data.status == 200) {
								Swal.fire({
									icon: 'success',
									title: data.message,
									text: data.desc,
									showCancelButton: false,
									confirmButtonText: 'Close',
								}).then((result) => {
									location.href = "{{"$segment/$folder"}}";
								});
							} else if (data.status == 500) {
								Swal.fire({
									icon: 'error',
									title: data.message,
									text: data.desc,
									showCancelButton: false,
									confirmButtonText: 'Close',
								}).then((result) => {
									location.reload();
								});
							}
						}
					});
				}else{
					return false;
				}
			});
	
			return false;
		}
	
	
		
		</script>
		<!--end::Javascript-->

	</body>
	<!--end::Body-->
</html>