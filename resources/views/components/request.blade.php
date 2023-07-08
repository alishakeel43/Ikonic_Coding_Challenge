@foreach ($request as $item)

<div class="my-2 shadow text-white bg-dark p-1" id="request_item_{{$item->id}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$item->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$item->email}}</td>
      <td class="align-middle">
    </table>
    <div>
      @if ($mode == 'sent')
        <button id="cancel_request_btn_{{$item->id}}" class="btn btn-danger me-1"
          onclick="deleteRequest({{auth()->user()->id}},{{$item->id}})">Withdraw Request</button>
      @else
        <button id="accept_request_btn_{{$item->id}}" class="btn btn-primary me-1"
          onclick="acceptRequest({{auth()->user()->id}},{{$item->id}})">Accept</button>
      @endif
    </div>
  </div>
</div>

@endforeach
