@extends('layouts.admin.main')
@section('styles')
<link href="{!! asset('static/bootstrap-toggle-master/css/bootstrap-toggle.min.css') !!}" media="all" rel="stylesheet" type="text/css" />
@stop
@section('content')
<section class="content-header">
   <h1>
      How to Paint
   </h1>
   @include('flash-message')
   <?php 
        $myPermit = explode(",",Auth::user()->permission);
    ?>
</section>
<section class="content">
   <div class="row">
   <div class="col-sm-12">
   <div class="box box-gold">
      <div class="box-header">
         <h3 class="box-title"><i class="fa fa-plus-circle"></i> Create How to Paint </h3>
      </div>
      <div class="box-body">
         <div class="row">
            <div class="col-lg-12">
               <div class="col-lg-5">
                  <form action="{{ URL::to('admin/how-to-paint/store') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                     {!! csrf_field() !!}
                     <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="title" id="title" value="{!! old('title') !!}" class="form-control {{($errors->first('title') ? form-error : '')}}" placeholder="Enter Title">
                     </div>
                     <div class="form-group">
                        <label>Parent Title</label>
                        <select class="form-control" name="parent_id" id="parent_id">
                           <option value="0">--- Title ---</option>
                           @if(!empty($HowToPaint[0]))
                           @php $subsub_ids = []; @endphp
                           @foreach( $HowToPaint as $list )
                           @if($list->parent_id == 0)
                           <option value="{{ $list->id }}">{{ $list->title }}</option>
                           @endif
                              @foreach($list->SubTitles as $subtitle)
                                 @if($subtitle->parent_id != 0 && !in_array($subtitle->id,$subsub_ids))
                                 <option value="{{ $subtitle->id }}">&nbsp;&nbsp;&nbsp;{{ $subtitle->title }}</option>
                                 @endif
                                 @foreach($subtitle->SubTitles as $subsub)
                                    @php array_push($subsub_ids,$subsub->id); @endphp
                                    <option value="{{ $subsub->id }}" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsub->title }}</option>
                                 @endforeach
                              @endforeach
                           @endforeach
                           @endif
                        </select>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-md-12 col-sm-12 col-xs-12">
                              <div class="col-md-12 col-sm-12 col-xs-12">
                                 <div class="form-group">
                                    <input type="checkbox" name="status" id="status" class="checkbox checkbox_status" checked/>
                                    <label>Active</label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @if(in_array(5.2, $myPermit))
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right">
                           <button type="submit" class="btn btn-gold pull-right">Add Title</button>
                        </div>
                        @endif
                  </form>
                  </div>
               </div>
               <div class="col-lg-7">
                  <div class="row ">
                     <div class="col-md-offset-6 col-sm-offset-6 col-md-6 col-sm-6 col-xs-12">
                        <form  action="{{ URL::to('admin/how-to-paint') }}" method="get"  accept-charset="UTF-8" enctype="multipart/form-data">
                           {!! csrf_field() !!}
                           <div class="input-group">
                              <input type="text" class="form-control input-gold" name="search_item" value="{{($search_item) ? $search_item : ''}}">
                              <span class="input-group-btn">
                              <button type="submit" class="btn btn-gold"><i class="fa fa-search"></i> Search Title</button>
                              </span>
                           </div>
                        </form>
                     </div>
                  </div>
                  @if($HowToPaint)       
                  <table class="table table-striped table-accordion">
                     <thead>
                        <tr>
                           <th>Title</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($HowToPaint[0]))
                        @php $x = 1; @endphp
                        @foreach( $HowToPaint as $list )
                        @if($list->parent_id == 0)
                        <tr data-toggle="collapse" data-target="#cat{{$x}}" class="accordion-toggle table-row-toggle" aria-expanded="false">
                           <td>{{ $list->title }}</td>
                           <td>
                              @if(in_array(5.1, $myPermit))
                              <a class="badge bg-green edit-howtopaint-title" data-id="{{$list->id}}" data-parent_id="{{$list->parent_id}}" data-title="{{$list->title}}" data-status="{{$list->status}}">
                              <span class="fa fa-edit"></span> View
                              </a>
                              @endif
                              @if(in_array(5.4, $myPermit))
                              <form action="{{ URL::to('admin/how-to-paint/destroy', $list->id) }}" method="POST">
                                 <input type="hidden" name="_method" value="DELETE">
                                 <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                 <a id="alert{{$list->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                              </form>
                              @endif
                           </td>
                        </tr>
                        <tr>
                           <td colspan="3"></td>
                        </tr>
                        @endif
                        @if($list->parent_id == 0)
                        <tr>
                           <td colspan="6" class="hiddenRow">
                              <div class="accordion-body collapse" id="cat{{$x}}">
                                 <table class="table table-striped table-bordered">
                                    <tbody>
                                       @if ($list->SubTitles->count() > 0)
                                       @foreach($list->SubTitles as $subtitle)
                                       <tr class="show_content" style="cursor:pointer" data-id="{{$subtitle->id}}">
                                          <td>&nbsp;&nbsp;&nbsp;{{ $subtitle->title }}</td>
                                          <td>
                                             @if(in_array(5.2, $myPermit))
                                            <a href="#" class="badge bg-green add-content" data-id="{{$subtitle->id}}" data-title="{{$subtitle->title}}"> 
                                              <span class="fa fa-edit"></span> Add
                                            </a>
                                            @endif
                                            @if(in_array(5.3, $myPermit))
                                             <a class="badge bg-green edit-howtopaint-title" data-id="{{$subtitle->id}}" data-parent_id="{{$subtitle->parent_id}}" data-title="{{$subtitle->title}}" data-status="{{$subtitle->status}}">
                                             <span class="fa fa-edit"></span> Edit
                                             </a>
                                             @endif
                                             @if(in_array(5.4, $myPermit))
                                             <form action="{{ URL::action('Admin\HowToPaintController@destroy', $subtitle->id) }}" method="POST">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                <a id="alert{{$subtitle->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                             </form>
                                             @endif
                                          </td>
                                       </tr>
                                       @foreach($subtitle->SubTitles as $subsub)
                                          <tr class="show_content" style="cursor:pointer" data-id="{{$subsub->id}}">
                                             <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsub->title }}</td>
                                             <td>
                                             @if(in_array(5.2, $myPermit))
                                             <a href="#" class="badge bg-green add-content" data-id="{{$subsub->id}}" data-title="{{$subsub->title}}"> 
                                                <span class="fa fa-edit"></span> Add
                                             </a>
                                             @endif
                                             @if(in_array(5.3, $myPermit))
                                                <a class="badge bg-green edit-howtopaint-title" data-id="{{$subsub->id}}" data-parent_id="{{$subsub->parent_id}}" data-title="{{$subsub->title}}" data-status="{{$subsub->status}}">
                                                <span class="fa fa-edit"></span> Edit
                                                </a>
                                             @endif
                                             @if(in_array(5.4, $myPermit))
                                                <form action="{{ URL::action('Admin\HowToPaintController@destroy', $subsub->id) }}" method="POST">
                                                   <input type="hidden" name="_method" value="DELETE">
                                                   <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                   <a id="alert{{$subsub->id}}" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>
                                                </form>
                                             @endif
                                             </td>
                                          </tr>
                                       @endforeach
                                       @endforeach
                                       @else
                                       <tr>
                                          <td colspan="3">No sub titles here!</td>
                                       </tr>
                                       @endif
                                    </tbody>
                                 </table>
                           </td>
                        </tr>
                        <tr>
                        <td colspan="6" class="hiddenRow"></td>
                        </tr>
                        @endif
                        @php
                        $x++;
                        @endphp
                        @endforeach
                        @else
                        <tr>
                        <td colspan="3">Nothing here!</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  @endif
                  <div class="pagination"> {{ $HowToPaint->links() }} </div>
                  </div>
                  <div id="addContentModal" class="modal fade" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <div class="panel panel-primary">
                           <form action="{{ URL::to('admin/how-to-paint/add-content') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                              <div class="panel-heading">
                                 <h4 class="modal-title">How To Paint add content</h4>
                              </div>
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                       <input type="hidden" name="ac_how_to_paint_id" id="ac_how_to_paint_id" />
                                       <div class="form-group">
                                          <label>Content</label>
                                          <textarea name="ac_content" id="ac_content" class="form-control content_txt" rows="3" placeholder="Enter ..." style="display: none;"></textarea>
                                       </div>
                                       <div class="form-group">
                                          <label for="ac_image">Image</label>
                                          <input type="file" class="form-control" name="ac_image" id="ac_image">
                                        </div>
                                       <div class="form-group">
                                          <input type="checkbox" name="ac_status" id="ac_status"  class="checkbox checkbox_status" checked/>
                                          <label>Active</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <div class="form-group edit_img">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer" style="text-align: right">
                                 <div class="button-group">
                                    {!! csrf_field() !!}   
                                    <button type="submit" class="btn btn-success">Add</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div id="editMdl" class="modal fade" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <div class="panel panel-primary">
                           <form action="{{ URL::to('admin/how-to-paint/update') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                              <div class="panel-heading">
                                 <h4 class="modal-title">Edit How To Paint</h4>
                              </div>
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                       <input type="hidden" name="e_id" id="e_id" />
                                       <div class="form-group">
                                          <label>Title</label>
                                          <input type="text" name="e_title" id="e_title" value="{!! old('e_title') !!}" class="form-control" placeholder="Enter Title">
                                       </div>
                                       <div class="form-group">
                                          <label>Parent Title</label>
                                          <select class="form-control" name="e_parent_id" id="e_parent_id">
                                             <option value="0">--- Title ---</option>
                                             @if(!empty($HowToPaint[0]))
                                             @php $subsub_ids = []; @endphp
                                             @foreach( $HowToPaint as $list )
                                             @if($list->parent_id == 0)
                                             <option value="{{ $list->id }}">{{ $list->title }}</option>
                                             @endif
                                                @foreach($list->SubTitles as $subtitle)
                                                   @if($subtitle->parent_id != 0 && !in_array($subtitle->id,$subsub_ids))
                                                   <option value="{{ $subtitle->id }}">&nbsp;&nbsp;&nbsp;{{ $subtitle->title }}</option>
                                                   @endif
                                                   @foreach($subtitle->SubTitles as $subsub)
                                                      @php array_push($subsub_ids,$subsub->id); @endphp
                                                      <option value="{{ $subsub->id }}" disabled>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $subsub->title }}</option>
                                                   @endforeach
                                                @endforeach
                                             @endforeach
                                             @endif
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <input type="checkbox" name="e_status" id="e_status"  class="checkbox checkbox_status"/>
                                          <label>Active</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <div class="form-group edit_img">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer" style="text-align: right">
                                 <div class="button-group">
                                    {!! csrf_field() !!}   
                                    @if(in_array(5.3, $myPermit))
                                    <button type="submit" class="btn btn-success">Update</button>
                                    @endif
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                  @if($HowToPaint)       
                  <table id="howToPaintContentsTbl" class="table table-striped table-accordion">
                     <thead>
                        <tr>
                           <th>Image</th>
                           <th>Content</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                        <td colspan="3">Nothing here!</td>
                        </tr>
                     </tbody>
                  </table>
                  @endif
                  <div class="pagination"> {{ $HowToPaint->links() }} </div>
                  </div>
                  <div id="addContentModal" class="modal fade" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <div class="panel panel-primary">
                           <form action="{{ URL::to('admin/how-to-paint/add-content') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                              <div class="panel-heading">
                                 <h4 class="modal-title">How To Paint add content</h4>
                              </div>
                              <div class="panel-body">
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                       <input type="hidden" name="ac_how_to_paint_id" id="ac_how_to_paint_id" />
                                       <div class="form-group">
                                          <label>Content</label>
                                          <textarea name="ac_content" id="ac_content" class="form-control content_txt" rows="3" placeholder="Enter ..." style="display: none;"></textarea>
                                       </div>
                                       <div class="form-group">
                                          <label for="ac_image">Image</label>
                                          <input type="file" class="form-control" name="ac_image" id="ac_image">
                                        </div>
                                       <div class="form-group">
                                          <input type="checkbox" name="ac_status" id="ac_status"  class="checkbox checkbox_status" checked/>
                                          <label>Active</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <div class="form-group edit_img">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer" style="text-align: right">
                                 <div class="button-group">
                                    {!! csrf_field() !!}   
                                    <button type="submit" class="btn btn-success">Add</button>
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
                  <div id="editContentModal" class="modal fade" role="dialog">
                     <div class="modal-dialog modal-lg">
                        <div class="panel panel-primary">
                           <form action="{{ URL::to('admin/how-to-paint/update-content') }}" method="post"accept-charset="UTF-8"  enctype="multipart/form-data">
                              <div class="panel-heading">
                                 <h4 class="modal-title">How To Paint edit content</h4>
                              </div>
                              <div class="panel-body">
                              <input type="hidden" name="ec_id" id="ec_id" />
                                 <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                       <input type="hidden" name="ec_how_to_paint_id" id="ec_how_to_paint_id" />
                                       <div class="form-group">
                                          <label>Content</label>
                                          <textarea name="ec_content" id="ec_content" class="form-control" rows="10" placeholder="Enter ..." style="display: none;"></textarea>
                                       </div>
                                       <div class="form-group">
                                          <label for="ec_image">Image</label>
                                          <img width="233" height="156" id="ec_show_image" src="{{url('/').'img/no_image.png'}}"/>
                                          <input type="file" class="form-control" name="ec_image" id="ec_image" onchange="document.getElementById('ec_show_image').src = window.URL.createObjectURL(this.files[0])">
                                        </div>
                                       <div class="form-group">
                                          <input type="checkbox" name="ec_status" id="ec_status"  class="checkbox checkbox_status" checked/>
                                          <label>Active</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                       <div class="form-group edit_img">
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="panel-footer" style="text-align: right">
                                 <div class="button-group">
                                    {!! csrf_field() !!}   
                                    @if(in_array(5.3, $myPermit))
                                    <button type="submit" class="btn btn-success">Update</button>
                                    @endif
                                    <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
         </div>
      </div>
   </div>
</section>
@stop
@section('scripts')
<script type="text/javascript" src="{{URL::asset('static/bootstrap-toggle-master/js/bootstrap-toggle.min.js')}}"></script>
<script>
   $(document).ready(function() {
      //Delete product
      $("a[id*=alert]").on("click", function(){
            if(confirm("Do you want to delete this item?")){
               $(this).parent('form').submit();
            }
      });

      $('.edit-howtopaint-title').on('click', function() {
         var id        = $(this).data('id');
         var parent_id = $(this).data('parent_id');
         var title     = $(this).data('title');
         var status    = $(this).data('status'); 

         $('#e_id').val(id);
         $('#e_parent_id').val(parent_id).change();;
         $('#e_title').val(title);
         status == 1 ? $('#e_status').attr('checked',true) : $('#e_status').attr('checked',false)
         $('#editMdl').modal();
      }); 

      $('.add-content').on('click', function() {
         var id = $(this).data('id');
         $('#ac_how_to_paint_id').val(id);
         $('#addContentModal').modal();
      });

      $('.show_content').on('click', function() {
         var id      = $(this).data('id');
         var _token  = $('input[name="_token"]').val();
         var edit_permit    = '<?php echo  in_array(5.3, $myPermit) ?>';
         var delete_permit  = '<?php echo  in_array(5.4, $myPermit) ?>';
         if (id && _token) { 
            $.ajax({
               url: base_url + '/admin/how-to-paint/show-content',
               dataType: 'json',
               method: 'post',
               cache: false,
               data: {_token,id},
               success: function (data) {
                  var html = "";
                  data.map(function(value) {
                    var image_val = value.image !== "" ? '/img/how-to-paint/' + value.image : '/img/no_image.png'; 
                    html += '<tr>' +
                     '<td>' + '<img width="233" height="156" src="'+image_val+'">' + '</td>' +
                     '<td>' + value.content + '</td>' +
                     '<td>';

                     if(edit_permit) {
                        html +=
                           '<a class="badge bg-green edit-howtopaint-content" data-id="'+ value.id+'" data-how_to_paint_id="' +value.how_to_paint_id+ '" data-image="'+ value.image +'" data-status="' +value.status+ '">' +
                           '<span class="fa fa-edit"></span> Edit' +
                           '</a>';
                     }
                     if(delete_permit) {
                        html += 
                           '<form action="{{url('/')}}/admin/how-to-paint/destroy-content/'+value.id+'" method="POST">' +
                              '<input type="hidden" name="_method" value="DELETE">' +
                              '<input type="hidden" name="_token" value="' +_token+ '" />' +
                              '<a id="delete-' +value.id+ '" class="badge bg-red"><span class="fa fa-trash"></span> Delete</a>' +
                           '</form>';
                     }

                     html += '</td>' + '</tr>';
                     $('#howToPaintContentsTbl').find('tbody').html(html);
                     $('.edit-howtopaint-content').click(function() {
                        var id              = $(this).data('id');
                        var image           = $(this).data('image');
                        var content         = $(this).parent().prev().html();
                        var status          = $(this).data('status');
                        $('#ec_id').val(id);
                        $('#ec_show_image').attr('src',image_val);
                        //$('#ec_image').val(image);
                        $('textarea#ec_content').summernote('code',content);
                        status == 1 ? $('#ec_status').attr('checked',true) : $('#ec_status').attr('checked',false)
                        $('#editContentModal').modal();
                     });
                     $('#delete-'+value.id).click(function() {
                        if(confirm('Are you sure you want to delete this content?')) {
                           $(this).parent().submit();
                        }
                     });
                  });
                  if (html === "") {
                     html = '<tr><td colspan="3">Nothing here!</td></tr>';
                     $('#howToPaintContentsTbl').find('tbody').html(html);
                  }
               }, error: function (e) {
                  console.log(e.responseText);
               }
            });
         }
      });
   });
</script>
@stop