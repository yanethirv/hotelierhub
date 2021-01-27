@if ($action == 1)
<div class="card">
  <div class="card-content">
    <div class="card-body">
      <div class="row">
        <div class="col-12">
          <div class="ag-grid-btns d-flex justify-content-between flex-wrap mb-1">
            <div class="dropdown sort-dropdown mb-1 mb-sm-0">
              @include('common.search')
            </div>

            <div class="ag-btns d-flex flex-wrap">
                <div class="action-btns">
                    <div class="btn-dropdown ">
                        <div class="btn-group dropdown actions-dropodown">

                        </div>
                    </div>
                </div>
            </div>
          </div>
          @include('common.alerts')
          <div class="content-body">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead>
                  <tr>
                    <th class="text-center">{{ __("ID") }}</th>
                    <th class="text-center">{{ __("Service") }}</th>
                    <th class="text-center">{{ __("Hostname") }}</th>
                    <th class="text-center">{{ __("Status") }}</th>
                    <th class="text-center">{{ __("Actions") }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($activationServices as $activationService)
                    <tr>
                      <td class="text-center">{{ $activationService->id }}</td>
                      <td class="text-center">{{ $activationService->product->name }}</td>
                      <td class="text-center">{{ $activationService->user->hostname }}</td>
                        @if ($activationService->status === 'wait')
                          <td class="text-center"><i class="fa fa-circle font-small-3 text-warning mr-50"></i> {{ __("On Wait") }}</td>
                        @endif
                        @if ($activationService->status === 'process')
                          <td class="text-center"><i class="fa fa-circle font-small-3 text-primary mr-50"></i> {{ __("In Process") }}</td>
                        @endif
                        @if ($activationService->status === 'active')
                          <td class="text-center"><i class="fa fa-circle font-small-3 text-success mr-50"></i> {{ __("Active") }}</td>
                        @endif
                        @if ($activationService->status === 'inactive')
                          <td class="text-center"><i class="fa fa-circle font-small-3 text-danger mr-50"></i> {{ __("Inactive") }}</td>
                        @endif
                      <td class="text-center">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModalCenter">
                          {{ __("Edit status") }}
                        </button>
                          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-centered modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">{{ __("Edit status request") }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-left">
                                      <form action="{{ route('activation.update',$activationService->id) }}" method="POST">
                                        @csrf
                                        <input name="_method" type="hidden" value="PUT">
                                        <div class="form-group">
                                          <label for="description">{{ __("Status") }}</label>
                                          <div class="input-group">
                                              <select class="form-control" name="status">
                                                  <option value="active"
                                                  @if ($activationService->status === 'active')
                                                      selected
                                                  @endif
                                                  >{{ __("Active") }}</option>
          
                                                  <option value="inactive"
                                                  @if ($activationService->status === 'inactive')
                                                      selected
                                                  @endif
                                                  >{{ __("Inactive") }}</option>

                                                  <option value="process"
                                                  @if ($activationService->status === 'process')
                                                      selected
                                                  @endif
                                                  >{{ __("In Process") }}</option>

                                                  <option value="wait"
                                                  @if ($activationService->status === 'wait')
                                                      selected
                                                  @endif
                                                  >{{ __("On Wait") }}</option>
                                              </select>
                                          </div>
                                          @error('status') <span class="text-danger">{{ $message }}</span>@enderror
                                      </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __("Comment") }}</label>
                                            <textarea class="form-control" style="height:150px" name="comment" placeholder="comment"></textarea>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('activations-request') }}" class="btn btn-outline-primary">{{ __("Back") }}</a>
                                        <button class="btn btn-primary float-right" type="submit">{{ __("Save") }}</button>
                                    </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
              {{ $activationServices->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  @elseif($action == 2)
  @include('livewire.admin.activations.activations-form')
  @endif
  <script type="text/javascript">
  function myFunction(id)
  {
    let me = this;
    Swal.fire({
      title: 'Confirm',
      text: 'You want to delete the registration?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes',
      cancelButtonText: 'Cancel',
      closeOnConfirm: false
    }).then((result) => {
      if (result.value) {
        //console.log('ID', id);
        window.livewire.emit('deleteRow', id)
      }
    })
  }
  </script>
