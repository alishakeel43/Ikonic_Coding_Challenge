function ajaxForm(formItems) {
  var form = new FormData();
  formItems.forEach(formItem => {
    form.append(formItem[0], formItem[1]);
  });
  return form;
}



/**
 * 
 * @param {*} url route
 * @param {*} method POST or GET 
 * @param {*} functionsOnSuccess Array of functions that should be called after ajax
 * @param {*} form for POST request
 */
function ajax(url, method, functionsOnSuccess, form) {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  })

  if (typeof form === 'undefined') {
    form = new FormData;
  }

  if (typeof functionsOnSuccess === 'undefined') {
    functionsOnSuccess = [];
  }

  $.ajax({
    url: url,
    type: method,
    async: true,
    data: form,
    processData: false,
    contentType: false,
    dataType: 'json',
    error: function(xhr, textStatus, error) {
      console.log(xhr.responseText);
      console.log(xhr.statusText);
      console.log(textStatus);
      console.log(error);
    },
    success: function(response) {
      for (var j = 0; j < functionsOnSuccess.length; j++) {
        for (var i = 0; i < functionsOnSuccess[j][1].length; i++) {
          if (functionsOnSuccess[j][1][i] == "response") {
            functionsOnSuccess[j][1][i] = response;
          }
        }
        functionsOnSuccess[j][0].apply(this, functionsOnSuccess[j][1]);
      }
    }
  });
}


function listingAjaxFunction(route, page) {
  // show skeletons
  // hide content


    
  var functionsOnSuccess = [
    [listingShowSuccessFunction, [route, 'response']]
  ];

  if (typeof page !== 'undefined') {
    $("#skeleton").removeClass('d-none');
    ajax(route+"?page="+page , 'GET', functionsOnSuccess);
  } else {
    $("#content").addClass('d-none');
    $("#skeleton").removeClass('d-none');
    // GET
    ajax(route, 'GET', functionsOnSuccess);
  }

  // $("#content").removeClass('d-none');
  
}

function createAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [createSuccessFunction, [exampleVariable, 'response']]
  ];

  // POST 
  ajax(route, 'POST', functionsOnSuccess, form);

}

function deleteAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [deleteSuccessFunction, [exampleVariable, 'response']]
  ];

  // POST 
  ajax(route+"/"+exampleVariable[1][1], 'Delete', functionsOnSuccess, form);

}

function updateAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [updateSuccessFunction, [exampleVariable, 'response']]
  ];

  // PATCH 
  ajax(route+"/"+exampleVariable[1][1], 'PATCH', functionsOnSuccess, form);

}

function removeAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [removeSuccessFunction, [exampleVariable, 'response']]
  ];

  // Delete 
  ajax(route+"/"+exampleVariable[0][1], 'Delete', functionsOnSuccess, form);

}

function connectionInCommonAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [connectionInCommonSuccessFunction, [exampleVariable, 'response']]
  ];

  // GET 
  ajax(route+"/"+exampleVariable[0][1], 'GET', functionsOnSuccess, form);

}

function connectionInCommonSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  console.log(exampleVariable[0][1]);

  console.table(response);
  $("#connections_in_common_skeletons_"+exampleVariable[0][1]).addClass('d-none');
  $('#content_'+exampleVariable[0][1]).html(response['content']);
  if(response['newPageUrl'] == null){
    $("#load_more_connections_in_common_"+exampleVariable[0][1]).addClass('d-none');
  } else {
    $("#load_more_connections_in_common_"+exampleVariable[0][1]).removeClass('d-none');
    loadMoreArray[exampleVariable[0][1]] = response['currentPage'] + 1;
  }
  $('#get_suggestions_btn').html(response['suggestions']);

}

function connectionInCommonLoadMoreAjaxFunction(route,exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm(exampleVariable);

  var functionsOnSuccess = [
    [connectionInCommonLoadMoreSuccessFunction, [exampleVariable, 'response']]
  ];

  // GET 
  ajax(route+"/"+exampleVariable[0][1]+"?page="+loadMoreArray[exampleVariable[0][1]], 'GET', functionsOnSuccess, form);

}

function connectionInCommonLoadMoreSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  console.log(exampleVariable[0][1]);

  console.table(response);
  $("#connections_in_common_skeletons_"+exampleVariable[0][1]).addClass('d-none');
  if(response['currentPage'] == 1){
    $('#content_'+exampleVariable[0][1]).html(response['content']);  
  } else {
    $('#content_'+exampleVariable[0][1]).append(response['content']);
  }
  if(response['newPageUrl'] == null){
    $("#load_more_connections_in_common_"+exampleVariable[0][1]).addClass('d-none');
  } else {
    $("#load_more_connections_in_common_"+exampleVariable[0][1]).removeClass('d-none');
    loadMoreArray[exampleVariable[0][1]] = response['currentPage'] + 1;
  }
  $('#get_suggestions_btn').html(response['suggestions']);

}

function removeSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  console.log(exampleVariable[0][1]);

  console.table(response);
  $("#connection_row_"+exampleVariable[0][1]).addClass('d-none');
  $('#get_connections_btn').html(response['connections']);
  $('#get_suggestions_btn').html(response['suggestions']);
}



function createSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  // console.log(exampleVariable[1][1]);

  console.table(response);
  $("#suggestion_row_"+exampleVariable[1][1]).addClass('d-none');
  $('#get_suggestions_btn').html(response['suggestions']);
  $('#get_sent_requests_btn').html(response['sendRequests']);
}

function deleteSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  console.log(exampleVariable[1][1]);

  console.table(response);
  $("#request_item_"+exampleVariable[1][1]).addClass('d-none');
  $('#get_suggestions_btn').html(response['suggestions']);
  $('#get_sent_requests_btn').html(response['sendRequests']);
}

function updateSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  // $("#content").removeClass('connections_in_common_skeleton');
  // $("#content").removeClass('d-none');

  console.log(exampleVariable[1][1]);

  console.table(response);
  $("#request_item_"+exampleVariable[1][1]).addClass('d-none');
  $('#get_connections_btn').html(response['connections']);
  $('#get_received_requests_btn').html(response['receiveRequest']);
}


function listingShowSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  
  console.log(exampleVariable);
  $("#content").removeClass('d-none');

  if(response["newPageUrl"] != null){
    loadMore = true;
    activeTab = exampleVariable;
    skipCounter = response["currentPage"] + 1; 
    $('#load_more_btn_parent').removeClass('d-none');
  } else {
    loadMore = false;
    activeTab = exampleVariable;
    skipCounter = response["currentPage"];
    $('#load_more_btn_parent').addClass('d-none');
  }
  if(response["currentPage"] > 1){
    $('#content').append(response['content']);
  } else {


    if(exampleVariable == 'suggestion' ){
      // 'suggestionsTotal' => $suggestions->count(),
      // 'sendRequestTotal' => $suggestions->count(),
      // 'receiveRequestTotal' => $suggestions->count(),
      // 'connectionsTotal' => $suggestions->count(),
      $('#get_suggestions_btn').html(response['suggestionsTotal']);
      $('#get_sent_requests_btn').html(response['sendRequestTotal']);
      $('#get_received_requests_btn').html(response['receiveRequestTotal']);
      $('#get_connections_btn').html(response['connectionsTotal']);
    }
    
    // if(response["newPageUrl"] == null){
    //   $('#load_more_btn_parent').addClass('d-none');
    // }
    // $('#load_more_btn_parent').removeClass('d-none');
    $('#content').html(response['content']);

  }


  $("#skeleton").addClass('d-none');

}









// -----------
function exampleUseOfAjaxFunction(exampleVariable) {
  // show skeletons
  // hide content

  var form = ajaxForm([
    ['exampleVariable', exampleVariable],
  ]);

  var functionsOnSuccess = [
    [exampleOnSuccessFunction, [exampleVariable, 'response']]
  ];

  // POST 
  ajax('/test', 'POST', functionsOnSuccess, form);

  // GET
  ajax('/test/' + exampleVariable, 'POST', functionsOnSuccess);
}

function exampleOnSuccessFunction(exampleVariable, response) {
  // hide skeletons
  // show content

  console.log(exampleVariable);
  console.table(response);
  $('#content').html(response['content']);
}