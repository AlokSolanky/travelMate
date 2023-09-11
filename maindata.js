//  here we are getting our variable(locationContainer) used for the left side of the page to store the different location card
// which we have already created in html File

var locationContainer = document.getElementById("locationCards");

// this is a function called setMap,it is responsible for displaying the map every time when page loads

const setMap = () => {
  var mymap = L.map("root", { position: "topright" }).setView(
    [22.9734, 78.6569], //initiall coordinates where map will be focused
    5 //5 is the zooming level of the map
  );
  const tileUrl = "https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";

  const attribution =
    '&copy; <a href="https://www.openstreetmap.org/copyright">TravelMate</a>';

  const tiles = L.tileLayer(tileUrl, { attribution });

  // here our map will completely get installed on the page

  tiles.addTo(mymap);

  // here we are creating a the icon of marker called Icon
  var Icon = L.icon({
    iconUrl: "marker.png",
    iconSize: [35, 35], //size of icon  in px
  });

  // marker created we will later use it for popups or onclick kinda things
  var marker;

  // this is the popup that will be displayed on the map when user click on any marker
  var popup;

  // here we applied foreach loop so that we can iterate each value in our list database as mentioned above and item is passed which is nothing but
  // an element of the list database

  list.forEach((item) => {
    //here we are getting img url of the location and checking if it is not null, if it is empty that means we dont have img url
    if (item.locationInfo.img != "") {
      marker = L.marker(item.locationInfo.coordinate, { icon: Icon }).addTo(
        mymap
      ); //if we have img then we set the marker of that location on the map and assign it to the marker
      // popup = L.popup()
      //   .setLatLng(item.locationInfo.coordinate)
      //   .setContent(item.locationInfo.name);
      marker.bindPopup(item.locationInfo.name).openPopup(); // here we create popups for all the location and assign it to popup and then set the popup on marker
      marker.on("click", (ev) => {
        var latlng = mymap.mouseEventToLatLng(ev.originalEvent);
        list.forEach((item) => {
          if (
            Math.trunc(item.locationInfo.coordinate[0]) ==
              Math.trunc(latlng.lat) &&
            Math.trunc(item.locationInfo.coordinate[1]) ==
              Math.trunc(latlng.lng)
          ) {
            var sid = item.locationInfo.id;
            var spotid = sid.toString();
            // console.log(typeof spotid);
            let target_card = document.getElementById(spotid);
            console.log(target_card);
            let all_card = document.querySelectorAll(".card");
            for (let i = 0; i < 40; i++) {
              all_card[i].style.display = "none";
            }
            target_card.style.display = "block";
            target_card.style.marginLeft = "40px";
          }
        });
      });
    }
  });
};

//this function will create a img tag,set the img,and append the img tag to card ⭐NOTE⭐: card is the container that will contain all the data of a location
//and locationContainer is where all the card are there mainly the left side

const setImage = (item, card) => {
  var locationImg = document.createElement("img");
  locationImg.src = item.locationInfo.img;
  card.appendChild(locationImg);
};

//this function takes item,means an element of list Database, and locationContent(the place inside the locationContainer but below the img container)
// we create h3 tag give it the value locationName and append that h3 tag inside the locationContent
const setName = (item, locationContent) => {
  var locationName = document.createElement("h3");
  locationName.id = "locationName";
  locationName.innerHTML = item.locationInfo.name;
  locationContent.appendChild(locationName);
};

//this takes item and locationContent,create a paragraph give it the value from database and then append it to locationContent container
const setInfo = (item, locationContent) => {
  var info = document.createElement("p");
  info.id = "locationInfo";
  info.innerHTML = item.history.info;
  locationContent.appendChild(info);
};

//this set the attraction points in locationContent container
const setAttraction = (item, locationContent) => {
  let famousspots = "";
  var attractions = document.createElement("div");
  attractions.id = "locationAttractions";
  famousspots = item.history.attractionpoints.join(", ");
  attractions.innerHTML = "<b>Tourist Attractions</b> : " + famousspots;
  locationContent.appendChild(attractions);
};
const setButton = (item, locationContent) => {
  var button = document.createElement("button");
  button.id = "containerButton";
  button.innerHTML = "Visit Now";
  button.onclick = () =>
  {
    window.location.href = "signin.html";
  }
  var buttonContainer = document.createElement("div");
  buttonContainer.id = "buttonContainer";
  buttonContainer.appendChild(button);
  locationContent.appendChild(buttonContainer);
};

// this function set the best time to visit on each location
setTimeToVisit = (item, ratingComponent) => {
  let length = item.time.text.length;
  let first = item.time.text[0];
  let last = item.time.text[length - 1];

  var time = document.createElement("div");
  time.id = "locationTime";
  if (length >= 3) {
    time.innerHTML = first + " to " + last;
  } else if (length == 1) {
    time.innerHTML = first;
  } else {
    time.innerHTML = first + " and " + last;
  }
  ratingComponent.appendChild(time);
};

// this set the ratings given to the locatios
const setRating = (locationContent, item) => {
  var rating = "";
  var ratingComponent = document.createElement("div");
  ratingComponent.id = "ratingComponent";
  for (let i = 0; i < Math.floor(item.fair.rating); i++) {
    rating = rating.concat("⭐");
  }
  if (item.fair.rating > 4.5) {
    rating = rating.concat("⭐");
  }
  ratingComponent.innerHTML = "Rating : " + rating;
  setTimeToVisit(item, ratingComponent);
  locationContent.appendChild(ratingComponent);
};

// this is the method which takes the card and create setContent inside card
const setContent = (item, card) => {
  var locationContent = document.createElement("div");
  locationContent.id = "contentContainer";

  card.appendChild(locationContent);
  setRating(locationContent, item);
  setName(item, locationContent);
  setInfo(item, locationContent);
  setAttraction(item, locationContent);
  setButton(item, locationContent);
};
// this method is responsible for setting up the card, it will create card and then append it to the locationContainer
const setCard = (item) => {
  var card = document.createElement("div");
  card.className = "card";
  var locationId = "";

  locationId += item.locationInfo.id;
  card.id = locationId;
  locationContainer.appendChild(card);
  setImage(item, card);
  setContent(item, card);
};

function searchFunction()
{
    console.log("inside searchFunction");
  let search = document.getElementById("searchcontent").value;
  list.forEach((item)=>
  {
    if(item.locationInfo.name.includes(search) || item.history.attractionpoints.includes(search) || item.time.text.includes(search))
    {
      var sid = item.locationInfo.id;
      var spotid = sid.toString();
      console.log(typeof spotid);
      let target_card = document.getElementById(spotid);
      console.log(target_card);
      let all_card = document.querySelectorAll(".card");
      for (let i = 0; i < 40; i++) {
        all_card[i].style.display = "none";
      }
      target_card.style.display = "block";
      target_card.style.marginLeft = "40px";
    }
  })

}

// this is the method that be called on page load that will set up the left part means cards for each location and right side means map on the page
window.onload = function setUp() {
  // this is the syntax of forEach loop that takes item from the calling array list
  list.forEach((item) => {
    if (item.locationInfo.name != "") {
      setCard(item);
    }
  });
  setMap();
};
