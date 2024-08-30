const apiKey = '25bc889758f52fbf19758448e96ffbb3';//api key



function getWeatherData(city) {
    const apiUrl = `https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${apiKey}&units=metric`;
    fetch(apiUrl)
        .then(response => {
            if (!response.ok) {
                throw new Error('City not found! Please enter a valid city name.');
            }
            return response.json();//format in apiorg
        })
        .then(data => {
            displayWeatherData(data);
           
        })
        .catch(error => {
            displayErrorMessage(error.message);
        });
}
function checkOnline(){
    return navigator.onLine
}

function displayWeatherData(data) {
    const currentDate = new Date();
    const iconElement = document.querySelector(".weather-icon");
    const options = { weekday: 'long', month: 'short', day: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString(undefined, options);
    const iconurl = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`
    document.getElementById('city').textContent = `City: ${data.name}`;
//local storage add items
    localStorage.setItem(data.name,JSON.stringify(data))
       document.getElementById("iconn").innerHTML =`<img src="${iconurl}" alt="">`;
       document.getElementById('date').textContent = `Date: ${formattedDate}`;
       document.getElementById('w-condition').textContent = `Weather: ${data.weather[0].description}`;
       document.getElementById('temp').textContent = `Temperature: ${data.main.temp}°C`;
       document.getElementById('pressure').textContent = `Pressure: ${data.main.pressure} hPa`;
       document.getElementById('wind-speed').textContent = `Wind Speed: ${data.wind.speed} m/s`;
       document.getElementById('humidity').textContent = `Humidity: ${data.main.humidity}%`;
}


function localStorageData(city){
    const result = localStorage.getItem(city)
    const data = JSON.parse(result)
    const iconurl = `https://openweathermap.org/img/wn/${data.weather[0].icon}.png`

    const currentDate = new Date();
    const iconElement = document.querySelector(".weather-icon");
    const options = { weekday: 'long', month: 'short', day: 'numeric' };
    const formattedDate = currentDate.toLocaleDateString(undefined, options);
    document.getElementById("iconn").innerHTML =`<img src="${iconurl}" alt="">`;
    document.getElementById('city').textContent = `City: ${data.name}`;
    document.getElementById('date').textContent = `Date: ${formattedDate}`;
    document.getElementById('w-condition').textContent = `Weather: ${data.weather[0].description}`;
    document.getElementById('temp').textContent = `Temperature: ${data.main.temp}°C`;
    document.getElementById('pressure').textContent = `Pressure: ${data.main.pressure} hPa`;
    document.getElementById('wind-speed').textContent = `Wind Speed: ${data.wind.speed} m/s`;
    document.getElementById('humidity').textContent = `Humidity: ${data.main.humidity}%`;
}

document.addEventListener('DOMContentLoaded', () => {
    getWeatherData("Reading");//assigned city
});

document.getElementById('btn').addEventListener('click', () => {
    const city = document.getElementById('city1').value;
    if (city === "") {
        alert("Please enter a city name.");//display when wrong city is entered
        return;
    } 
    if (checkOnline()){
        getWeatherData(city)
    }else{
        localStorageData(city)
    }
    
    // else {
    //     getWeatherData(city);
    //     document.getElementById('error').textContent = '';
    // }
    document.getElementById('city1').value = '';
});

document.getElementById('city1').addEventListener('keydown', (event) => {
    if (event.key === "Enter") {
        const city = document.getElementById('city1').value;
        if (city === "") {
            alert("Please enter a city name.");
            return;
        } else {
            getWeatherData(city);
            document.getElementById('error').textContent = '';
        }
        document.getElementById('city1').value = '';//clears the entered data after loading
    }
});
iconElement.innerHTML=`<img src=" /${weather.iconID}.png"/>`;

function displayErrorMessage(message) {
    document.getElementById('city').textContent = '';
    document.getElementById('date').textContent = '';
    document.getElementById('w-condition').textContent = '';
    document.getElementById('temp').textContent = '';
    document.getElementById('pressure').textContent = '';
    document.getElementById('wind-speed').textContent = '';
    document.getElementById('humidity').textContent = '';

    const errorMessage = document.getElementById('error');
    errorMessage.textContent = message;
}
fetch('http://localhost/weather/manisha.php')
// Convert response string to json object
.then(response => response.json())
.then(response => {
  
 
  // Display whole API response in browser console (take a look at it!)
 
  // Copy one element of response to our HTML paragraph
  console.log(response)
  document.querySelector(".city").innerHTML =response['name'];
  document.querySelector(".desc").innerHTML =response.description;
  document.querySelector(".tem").innerHTML =response.temperature+'°C';
  document.querySelector(".Pressure").innerHTML ="Pressure : "+response.pressure+' hPa';
  document.querySelector(".hum").innerHTML ="Humidity : "+response.humidity+"%";
  document.querySelector(".Wind_speed").innerHTML ="Wind Speed: "+response.windspeed+' m/s';
  document.querySelector(".Wind_Direction").innerHTML="Wind Direction: "+response.winddirection+' degree N';
  document.querySelector('.date').innerHTML ="Date and day: " + date;   
})
.catch(err => {
// Display errors in console
console.log(err);
});