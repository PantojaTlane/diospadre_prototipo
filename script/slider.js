var slideImg = document.getElementById("imageSlider");

var images = new Array(
    "./img/img1.jpg",
    "./img/img2.jpg",
    "./img/img3.jpg",
    "./img/img4.jpg"
);

var len = images.length;
var i = 0;

setInterval(()=>{
    if (i > len - 1) {
        i = 0;
    }
    slideImg.src = images[i];
    i++;
}, 5000);