var skeletonId = 'skeleton';
var contentId = 'content';
var skipCounter = 0;
var takeAmount = 10;

var loadMore = false;
var activeTab = "suggestions";

var loadMoreArray = [];


function getRequests(mode) {
  // your code here...
}

function getMoreRequests(mode) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnections() {
  // your code here...
}

function getMoreConnections() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function getConnectionsInCommon(userId) {

  connectionInCommonAjaxFunction('connection',[["userId" , userId]]);
  
  // your code here...
}

function getMoreConnectionsInCommon(userId) {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
  connectionInCommonLoadMoreAjaxFunction('connection',[["userId" , userId]])
}

function getSuggestions() {
  // your code here...

  // exampleUseOfAjaxFunction('example_route');
  // payload = new Array();
  // payload['pageNo'] = 2;
  
  $("#content").html('');
  listingAjaxFunction('suggestion');

}

function tabListing(tabName){
  listingAjaxFunction(tabName);
}

function getMoreSuggestions() {
  // Optional: Depends on how you handle the "Load more"-Functionality
  // your code here...
}

function sendRequest(userId, suggestionId) {
  // your code here...
  // payload = {"userId":userId, "suggestionId":suggestionId}
  createAjaxFunction('send_request',[["userId" , userId], ["suggestionId",suggestionId]]);
  
}

function deleteRequest(userId, requestId) {
  // your code here...
  deleteAjaxFunction('send_request',[["sender_user_id" , userId], ["receiver_user_id",requestId]]);
  
}

function acceptRequest(userId, requestId) {
  // your code here...
  updateAjaxFunction('receive_request',[["sender_user_id" , userId], ["receiver_user_id",requestId]]);
  
}

function removeConnection(userId, connectionId) {
  // your code here...
  removeAjaxFunction('connection',[["id" ,connectionId]]);
}

function loadMoreBtn() {

  listingAjaxFunction(activeTab,skipCounter);
}

$(function () {
  getSuggestions();

});