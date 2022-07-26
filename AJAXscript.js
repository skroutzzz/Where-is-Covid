var btn = document.getElementById("load");
btn.addEventListener("click", function () {
  var ourRequest = new XMLHttpRequest();
  //ourRequest.onload = reqListener;
  ourRequest.open("GET", "uploads/generic.json", "true");
  ourRequest.onload = function () {
    var ourData = JSON.parse(ourRequest.responseText);
    //console.log(ourData);
    renderHTML(ourData);
  };
  ourRequest.send();
});

function renderHTML(data) {
  var htmlString = "";

  for (i = 0; i < data.length; i++) {
    htmlString += "<p>" + data[i].name + " is " + data[i].address + "</p>";
  }

  document
    .getElementById("content")
    .insertAdjacentHTML("beforeend", htmlString);
}

/*
function renderHTML(data) {
  var htmlString = "";

  for (i = 0; i < data.length; i++) {
    htmlString += "<p>" + data[i].name + "is a " + data[i].species + "</p>";
  }
  document
    .getElementById("animal-info")
    .insertAdjacentHTML("beforeend", htmlString);
  //animalContainer.insertAdjacentHTML("beforeend", htmlString);
}

*/
