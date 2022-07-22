//var animalContainer = document.getElementById("animal-info");

var btn = document.getElementById("btn");
btn.addEventListener("click", function () {
  var ourRequest = new XMLHttpRequest();
  ourRequest.open(
    "GET",
    "https://learnwebcode.github.io/json-example/animals-1.json",
    "true"
  );
  ourRequest.onload = function () {
    var ourData = JSON.parse(ourRequest.responseText);
    renderHTML(ourData);
  };
  ourRequest.send();
});

//animalContainer.textContent("hELLO");

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
