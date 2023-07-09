const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const Theme = document.querySelector(".theme-toggler");
const onlyCow = document.querySelector(".onlyCow");
const date = document.querySelector(".pregYes");
const insdate = document.querySelector(".insDate");
const bullid = document.querySelector(".bullid");

function showNotification(message, duration) {
  var notificationContainer = document.getElementById("notificationContainer");

  var notification = document.createElement("div");
  notification.className = "notification";
  notification.textContent = message;

  notificationContainer.appendChild(notification);

  notification.classList.add("show");

  setTimeout(function () {

    notification.classList.remove("show");
    notification.classList.add("hide");
  }, duration - 1000);

  setTimeout(function () {
    notificationContainer.removeChild(notification);
  }, duration);
}



function edit()
{
  console.log("hehehe");
  //$("#id").prop("readonly", false).addClass("glow");
  $("#breed").prop("disabled", false).addClass("glow");
  //$("#gender").prop("disabled", false).addClass("glow");
  $(".color").prop("readonly", false).addClass("glow");
  $(".dob").prop("readonly", false).addClass("glow");
  $(".price").prop("readonly", false).addClass("glow");
  $("#insemination").prop("disabled", false).addClass("glow");
  $("#bid").prop("readonly", false).addClass("glow");
  $("#date").prop("readonly", false).addClass("glow");
  $("#pregnant").prop("disabled", false).addClass("glow");
  $("#startDate").prop("readonly", false).addClass("glow");
  $("#deliveryDate").prop("readonly", false).addClass("glow");
  $("#abortionDate").prop("readonly", false).addClass("glow");
  $(".general-btn").css("display", "block");
}

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

function redirectToProfile(cowid)
{  
  window.location.href = 'animalProfile?cowid=' + cowid;
}

function deleteBreed(breed)
{
  window.location.href = 'delete?breedName=' + breed;
}

function update(id)
{
  console.log("whyyyy");
  window.location.href = 'update?record=general&id=' + id;
}


// Function to set the theme class on the body element
function setTheme(theme) {
    document.body.classList.toggle('dark-theme-variables', theme === 'dark');
    Theme.querySelector('span:nth-child(1)').classList.toggle('active', theme === 'light');
    Theme.querySelector('span:nth-child(2)').classList.toggle('active', theme === 'dark');
  }
  
  // Function to handle the click event on the theme element
  function toggleTheme() {
    const currentTheme = localStorage.getItem('theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    localStorage.setItem('theme', newTheme);
    setTheme(newTheme);
  }
  
  // Add event listener to the theme element
  Theme.addEventListener('click', toggleTheme);
  
  // Apply the theme when the page loads
  document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme) {
      setTheme(savedTheme);
    } else {
      // If no theme preference is saved, default to light theme
      localStorage.setItem('theme', 'light');
    }
  });

document.getElementById("gender").addEventListener('change', function() {
    var value = this.value;
    if (value === 'Cow') 
    {  
      onlyCow.style.display = 'block';
    }
    else{
      onlyCow.style.display = 'none';
    }
})

document.getElementById("pregnant").addEventListener('change', function() {
    var value = this.value;
    if (value == 'yes') date.style.display = 'block';
    else date.style.display = 'none';

    // just for fun...okie now
})

document.getElementById("insemination").addEventListener('change', function() {
    var value = this.value;
    if (value == 'Artificial Insemination') 
    {
        bullid.style.display = 'none';
        insdate.style.display = 'block';
    }
    else if (value == 'Natural Insemination')
    {
        bullid.style.display = 'block';
        insdate.style.display = 'block'; 
    }
    else
    {
        bullid.style.display = 'none';
        insdate.style.display = 'none'; 
    }
})



