import $ from 'jquery';

//########## Fetch weather data ##########
async function fetchCityWeather(city) {
    //Init for api
    const APIKEY = '9220c16e1f5f8bbc3f78c4405e255582';
    let url = `https://api.openweathermap.org/data/2.5/weather?q=${city}&lang=fr&appid=${APIKEY}&units=metric`;
    //Get data from api
    let res = await fetch(url);
    let cityWeather = await res.json();

    //Generate HTML render
    let cityElement = createCityElement(cityWeather);
    insertCityElement(cityElement);
    saveToLocalStorage(cityElement);

    return cityWeather;
}

//########## Create city weather elements ##########
function createCityElement(cityWeather) {
    let cityElement = {
        ville: cityWeather.name,
        longitude: cityWeather.coord.lon,
        latitude: cityWeather.coord.lat,
        temperature: cityWeather.main.temp,
        max: cityWeather.main.temp_max,
        min: cityWeather.main.temp_min,
        image: `http://openweathermap.org/img/wn/${cityWeather.weather[0].icon}@2x.png`
    };
    return cityElement;
}

//########## Insert data in html table ##########
function insertCityElement(cityElement) {
    $('#tbody').append(`
    <tr>
    <td class="city">${cityElement.ville}</td>
    <td class="lon">${cityElement.longitude}</td>
    <td class="lat">${cityElement.latitude}</td>
    <td class="temp">${cityElement.temperature}°C</td>
    <td class="temp_max">${cityElement.max}°C</td>
    <td class="temp_min">${cityElement.min}°C</td>
    <td class="iconW"><img class="iconSrc" src=${cityElement.image} alt="..." /></td>
    <td><input type="button" value="X" class="btn btn-danger delete" name=${JSON.stringify(cityElement.ville)}></td>
    </tr>
`);
}

//########## Save to browser's local storage ##########
function saveToLocalStorage(cityElement) {
    let cities = [];
    if (localStorage.getItem('cities') != undefined) {
        cities = JSON.parse(localStorage.getItem('cities'));
        cities.push(cityElement);
    } else {
        cities.push(cityElement);
    }
    localStorage.setItem('cities', JSON.stringify(cities));
    return true;
}

//########## Refresh from browser's local storage ##########
function refreshFromLocalStorage() {
    let cities = [];
    if (localStorage.getItem('cities') != undefined) {
        cities = JSON.parse(localStorage.getItem('cities'));
        cities.map((item) => insertCityElement(item));
    } else {
        if (window.navigator.geolocation) {
            window.navigator.geolocation.getCurrentPosition(successfulLookup, console.log);
        }
    }
    localStorage.setItem('cities', JSON.stringify(cities));
    return true;
}

//########## Geocatch success function ##########
const successfulLookup = async position => {
    //Init for api
    const { latitude, longitude } = position.coords;
    const APIKEY = 'ca6b650a6dd34482bac6930dd4d85258';
    let url = `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${APIKEY}`;

    //Get data from api
    let res = await fetch(url);
    let geoCatch = await res.json();
    $('.geoCatch').text(geoCatch.results[0].formatted);
    city = geoCatch.results[0].formatted.split(',');
    city = city[1].substring(7);
    fetchCityWeather(city);
}

//########## Delete a city  ##########
function deleteCity(city) {
    let cities = JSON.parse(localStorage.getItem('cities'));
    cities = cities.filter(item => item.ville !== city);
    localStorage.setItem('cities', JSON.stringify(cities));
    $('#addCity').val("");
    location.reload();
    return true;
}

export { fetchCityWeather, createCityElement, insertCityElement, saveToLocalStorage, refreshFromLocalStorage, successfulLookup, deleteCity };