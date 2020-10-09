
<html lang="en">
<head>
<meta charset="UTF-8">
<style>
 .center {
 margin: 0;
 position: relative;
 top: 50%;
 left: 50%;
 -ms-transform: translate(-50%, -50%);
 transform: translate(-50%, -50%);
 }
</style>
</head>
<body>
<div id="first" style='padding:10px;display: inline-block;border: 1px solid grey;width:240px;height:320px;'>
<h3>1. load data</h3>
<button id="load">Load</button>
<h3>2. show list</h3>
<button id="elist">List</button>
<h3>3. search the knowledge base</h3>
<form id="searchForm" method="post">
 <input type="text" id="query" name="query"><br>
 <button id="search_btn">Search</button>
</form>
</div>
<!--
<div id="results" style='display: inline-block;border: 1px solid black;width:200px;vertical-align:top;'>
here will be data
</div>
-->
<script>
/* loading json */
document.getElementById('load').addEventListener('click', load_kb, false);
function load_kb(event) {
 var url ='http://dummy.restapiexample.com/api/v1/employees';
 var my_request = new XMLHttpRequest();
 my_request.open('get', url, true);
 my_request.onload = show_results;
 my_request.onerror = show_error;
 my_request.send();
}
function show_error() {
 alert('Request error');
}
function show_results() {
 clearPreviousResults();
 var mydiv = document.getElementById('first');
 var resultDiv = document.createElement('div');
 resultDiv.id = 'results';
 resultDiv.setAttribute("style", "display: inline-block;width:360px;height:340px;border: 1px solid black;overflowy: scroll;vertical-align:top;;");
 document.body.insertBefore(resultDiv, mydiv.nextSibling);
 //console.log(this.responseText);
 kb = JSON.parse(this.responseText);
 var resultData = document.createElement('pre');
 resultDiv.appendChild(resultData);
 resultData.innerHTML = JSON.stringify(kb, null, 4);
}

function clearPreviousResults(){
 let results = this.document.getElementById('results');
 if (results) {
 results.remove();
 }
 let photo = this.document.getElementById('photo');
 if (photo) {
 photo.remove();
 }
}
/* show employee list */
document.getElementById('elist').addEventListener('click', show_list, false);
function show_list(event){
 if (typeof(kb) !== "undefined") { // if results exist
 resultDiv = document.getElementById('results');
 resultDiv.innerHTML = "";
 var resultList = document.createElement('ul');
 resultDiv.appendChild(resultList);
 for (var i = 0; i < kb.data.length; ++i) {
 var article = kb.data[i];
 var resultItem = document.createElement('li');
 resultList.appendChild(resultItem);
 resultItem.innerHTML = '<a href="http://dummy.restapiexample.com/api/v1/employee/' + article.id + '" target="_blank">' + ar
ticle.employee_name + '</a>';
 }
 } else { // no results
 var result = document.createElement('p');
 result.innerHTML = 'No data';
 document.body.appendChild(result);
 }
}
/* search knowledge base */
document.getElementById('search_btn').addEventListener('click', search_kb, false);
function search_kb(event){
 clearPreviousResults();
 event.preventDefault();
 let search_string = encodeURIComponent(document.getElementById('query').value);
 //curl -X GET -
H "Authorization: 563492ad6f917000010000011e4d94210755433ebd3c48ab924dae67" "https://api.pexels.com/v1/search?query=nature&per_pa
ge=1"
 let url ='https://api.pexels.com/v1/search?query=' + search_string +'&per_page=1';
 let req = new XMLHttpRequest();
 req.open('get', url, true);
 req.setRequestHeader('Authorization', '563492ad6f917000010000011e4d94210755433ebd3c48ab924dae67')
 req.onload = search_results;
 req.onerror = search_error;
 req.send();
}
function search_error() {
 alert('Request error');
}

function search_results() {
 let data = JSON.parse(this.responseText);
 //console.log(JSON.stringify(data, null, 4));
 let photo = data.photos[0].src.small;
 //console.log(photo);
 let result = document.createElement('div');
 result.id = "photo";
 result.innerHTML = '<img src="' + photo + '" class="center">';
 result.setAttribute("style", "display: inline-block;height:340px;width:360px;vertical-align:top;");
 document.body.insertBefore(result, document.getElementById('first').nextSibling);

 // alert('ok');
}
</script>
</body>
</html>
