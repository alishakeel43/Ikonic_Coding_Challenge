@foreach($connections as $connection)
<div class="my-2 shadow text-white bg-dark p-1" id="connection_row_{{$connection->id}}">
  <div class="d-flex justify-content-between">
    <table class="ms-1">
      <td class="align-middle">{{$connection->name}}</td>
      <td class="align-middle"> - </td>
      <td class="align-middle">{{$connection->email}}</td>
      <td class="align-middle">
    </table>
    <div>
      <button style="width: 220px" onclick="getConnectionsInCommon({{$connection->id}})" id="get_connections_in_common_{{$connection->id}}" class="btn btn-primary" type="button"
        data-bs-toggle="collapse" data-bs-target="#collapse_{{$connection->id}}" aria-expanded="false" aria-controls="collapseExample">
        Connections in common{{$connection->id}} ({{$connection->connections->get()->count()}})
      </button>
      <button id="create_request_btn_" class="btn btn-danger me-1" onclick="removeConnection({{auth()->user()->id}},{{$connection->id}})">Remove Connection</button>
    </div>

  </div>
  <div class="collapse" id="collapse_{{$connection->id}}">

    <div id="content_{{$connection->id}}" class="p-2">
      {{-- Display data here --}}
      {{-- <x-connection_in_common /> --}}
    </div>
    <div id="connections_in_common_skeletons_{{$connection->id}}" class=''>
      {{-- Paste the loading skeletons here via Jquery before the ajax to get the connections in common --}}
        @for ($i = 0; $i < 10; $i++)
          <x-skeleton />
        @endfor
    </div>
    <div class="d-flex justify-content-center w-100 py-2">
      <button class="btn btn-sm btn-primary" onclick="getMoreConnectionsInCommon({{$connection->id}})" id="load_more_connections_in_common_{{$connection->id}}">Load
        more</button>
    </div>
  </div>
</div>
@endforeach
