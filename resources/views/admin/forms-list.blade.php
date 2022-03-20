  @extends('layouts.app')
  @section('content')
  <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Forms</h1>
      <p class="mb-4">
          <button class="btn btn-success" type="button"><a href="{{url('admin/forms/add')}}" class=" text-white">Add
                  New</a></button>
      </p>
      @include('layouts.show-message')

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
          <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">List</h6>
          </div>
          <div class="card-body">
              <div class="table-responsive">
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Form Name</th>
                              <th></th>
                          </tr>
                      </thead>

                      <tbody>

                          @forelse ($forms as $key => $form)
                          <tr>
                              <td>{{$form->form_name}}</td>
                              <td style="width:25%"><a href="{{url('admin/forms/edit/')}}/{{$form->id}}"><button
                                          class="btn btn-info" type="button" style="margin:5px;">Edit</button></a><a
                                      href="#" rel="nofollow"><button class="btn btn-danger dlt_btn" type="button"
                                          data-row_id="{{$form->id}}">Delete</button></td>
                          </tr>

                          @empty
                          <tr>
                              <td colspan="6" style="text-align:center">No data found</td>
                          </tr>
                          @endforelse

                      </tbody>
                  </table>

              </div>
              {{$forms->links()}}
          </div>

      </div>

  </div>



  @endsection
  @section('script')

  <script>
$(document).ready(function() {

    $('.dlt_btn').click(function() {
        var id = $(this).attr('data-row_id');
        if (deleteItem()) {
            $.ajax({
                url: "{{url('admin/forms/delete/')}}/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{csrf_token()}}",
                },

                success: function(res) {
                    if (res.status) {
                        showMessage(res.message, 'success');
                        window.location.reload();

                    } else {
                        showMessage(res.message, 'error');

                    }
                }

            })
        }

    })
})

function deleteItem() {
    if (confirm("Are you sure you want to delete?")) {
        return true;
    }
    return false;
}
  </script>
  @endsection