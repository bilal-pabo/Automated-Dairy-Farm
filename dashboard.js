const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu-btn");
const closeBtn = document.querySelector("#close-btn");
const theme = document.querySelector(".theme-toggler");
const onlyCow = document.querySelector(".onlyCow");
const date = document.querySelector(".pregYes");
const insdate = document.querySelector(".insDate");
const bullid = document.querySelector(".bullid");

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})

closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

theme.addEventListener('click', () => {
    document.body.classList.toggle('dark-theme-variables');
    theme.querySelector('span:nth-child(1)').classList.toggle('active');
    theme.querySelector('span:nth-child(2)').classList.toggle('active');
})

document.getElementById("gender").addEventListener('change', function() {
    var value = this.value;
    if (value == 'cow') 
    {
        onlyCow.style.display = 'block';
    }
    else onlyCow.style.display = 'none';
})

document.getElementById("pregnant").addEventListener('change', function() {
    var value = this.value;
    if (value == 'yes') date.style.display = 'block';
    else date.style.display = 'none';
})

document.getElementById("insemination").addEventListener('change', function() {
    var value = this.value;
    if (value == 'artificial') 
    {
        bullid.style.display = 'none';
        insdate.style.display = 'block';
    }
    else if (value == 'natural')
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
