@foreach ($suggestions as $item)

<div class="my-2 shadow  text-white bg-dark p-1" id="suggestion_row_{{$item->id}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$item->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$item->email}}</td>
      <td class="align-middle"> 
    </table>
    <div>
      <button id="create_request_btn_" onclick="sendRequest({{ Auth::user()->id }},{{$item->id}})" class="btn btn-primary me-1">Connect</button>
    </div>
  </div>
</div>
@endforeach