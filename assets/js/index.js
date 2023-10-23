// REVIEW SLIDER START
const wrapper = document.querySelector(".reviews_container");
const carousel = document.querySelector(".reviews_carousel");
const firstCardWidth = carousel.querySelector(".reviews_card").offsetWidth;
const arrowBtns = document.querySelectorAll(".reviews_container i");
const carouselChildrens = [...carousel.children];

let isDragging = false, isAutoPlay = true, startX, startScrollLeft, timeoutId;

// Get the number of cards that can fit in the carousel at once
let cardPerView = Math.round(carousel.offsetWidth / firstCardWidth);

// Insert copies of the last few cards to beginning of carousel for infinite scrolling
carouselChildrens.slice(-cardPerView).reverse().forEach(card => {
    carousel.insertAdjacentHTML("afterbegin", card.outerHTML);
});

// Insert copies of the first few cards to end of carousel for infinite scrolling
carouselChildrens.slice(0, cardPerView).forEach(card => {
    carousel.insertAdjacentHTML("beforeend", card.outerHTML);
});

// Scroll the carousel at appropriate postition to hide first few duplicate cards on Firefox
carousel.classList.add("no-transition");
carousel.scrollLeft = carousel.offsetWidth;
carousel.classList.remove("no-transition");

// Add event listeners for the arrow buttons to scroll the carousel left and right
arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
        carousel.scrollLeft += btn.id == "left" ? -firstCardWidth : firstCardWidth;
    });
});

const dragStart = (e) => {
    isDragging = true;
    carousel.classList.add("dragging");
    // Records the initial cursor and scroll position of the carousel
    startX = e.pageX;
    startScrollLeft = carousel.scrollLeft;
}

const dragging = (e) => {
    if (!isDragging) return; // if isDragging is false return from here
    // Updates the scroll position of the carousel based on the cursor movement
    carousel.scrollLeft = startScrollLeft - (e.pageX - startX);
}

const dragStop = () => {
    isDragging = false;
    carousel.classList.remove("dragging");
}

const infiniteScroll = () => {
    // If the carousel is at the beginning, scroll to the end
    if (carousel.scrollLeft === 0) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.scrollWidth - (2 * carousel.offsetWidth);
        carousel.classList.remove("no-transition");
    }
    // If the carousel is at the end, scroll to the beginning
    else if (Math.ceil(carousel.scrollLeft) === carousel.scrollWidth - carousel.offsetWidth) {
        carousel.classList.add("no-transition");
        carousel.scrollLeft = carousel.offsetWidth;
        carousel.classList.remove("no-transition");
    }

    // Clear existing timeout & start autoplay if mouse is not hovering over carousel
    clearTimeout(timeoutId);
    if (!wrapper.matches(":hover")) autoPlay();
}

const autoPlay = () => {
    if (window.innerWidth < 800 || !isAutoPlay) return; // Return if window is smaller than 800 or isAutoPlay is false
    // Autoplay the carousel after every 2500 ms
    timeoutId = setTimeout(() => carousel.scrollLeft += firstCardWidth, 2500);
}
autoPlay();

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mousemove", dragging);
document.addEventListener("mouseup", dragStop);
carousel.addEventListener("scroll", infiniteScroll);
wrapper.addEventListener("mouseenter", () => clearTimeout(timeoutId));
wrapper.addEventListener("mouseleave", autoPlay);
// REVIEW SLIDER END

// AUTH START
function previewAvatar(avatar) {
    const imageUrl = window.URL.createObjectURL(avatar.files[0])
    const avatarPreview = document.querySelector('#avatar-preview')
    avatarPreview.src = imageUrl
}

function togglePasswordHiddenIcon() {
    const passwordHiddenIcon = document.querySelector('#password_hidden_icon')
    const passwordField = document.querySelector('#password_field')
    if (passwordHiddenIcon.classList.contains("fa-eye-slash")) {
        passwordHiddenIcon.classList.add('fa-eye')
        passwordHiddenIcon.classList.remove('fa-eye-slash')
        return passwordField.type = "text"
    }
    if (passwordHiddenIcon.classList.contains("fa-eye")) {
        passwordHiddenIcon.classList.remove('fa-eye')
        passwordHiddenIcon.classList.add('fa-eye-slash')
        return passwordField.type = "password"
    }
}
// AUTH END

// CLOSE ALERT BOX
function closeErrorMsg() {
    const messageContainer = document.querySelectorAll('.message_container')
    messageContainer.forEach((message) => {
        message.style.display = "none"
    })
}

// RATING TEXT DISPLAY
function displayReviewContent(element) {
    const reviewResult = document.querySelector('.review_result')
    if (element.id === "one") {
        reviewResult.textContent = "I hate it"
    }
    if (element.id === "two") {
        reviewResult.textContent = "I don't like it"
    }
    if (element.id === "three") {
        reviewResult.textContent = "It is good"
    }
    if (element.id === "four") {
        reviewResult.textContent = "I like it"
    }
    if (element.id === "five") {
        reviewResult.textContent = "I love it"
    }
}

// PITCH /SWIMMING SITE DETAIL IMAGE THUMB-NAIL ONCLICK
function changeImage(element) {
    const mainImg = document.querySelector('.detail_main_image img')

    mainImg.src = element.href
}

function changeWearableText(item) {
    const title = document.querySelector('#wearable_title')
    const price = document.querySelector('#wearable_price')
    const description = document.querySelector("#wearable_description")
    const category = document.querySelector("#wearable_category")
    const stock = document.querySelector('#wearable_stock')

    const wearableItems = [
        {
            title: "GPS Watch",
            description: "A GPS watch, also known as a Global Positioning System watch, is a wearable device that combines a regular wristwatch with GPS technology. It allows the wearer to receive signals from multiple satellites in orbit around the Earth, which can accurately determine their geographical location.",
            price: 10500,
            category: "Navigation and GPS Devices",
            stock: 25
        },
        {
            title: "Head Lamp",
            description: "A headlamp is a portable, hands-free light source that is worn on the head using an elastic strap. It typically consists of a light-emitting diode (LED) or an incandescent bulb mounted in a housing, along with a strap that goes around the head to secure it in place.",
            price: 56000,
            category: "Illumination and Visibility",
            stock: 20
        },
        {
            title: "Mosquito Repellent Bracelet",
            description: "An Ultrasonic Mosquito Repellent Bracelet is a wearable device designed to help protect the wearer from mosquito bites. It utilizes ultrasonic technology to emit high-frequency sound waves that are intended to deter mosquitoes from approaching the person wearing the bracelet.",
            price: 70000,
            category: "Health and Safety",
            stock: 14
        },
        {
            title: "Solar Powered Charger",
            description: "A solar-powered charger, also known as a solar charger or solar power bank, is a portable device that uses sunlight to generate electrical energy for charging electronic devices like smartphones, tablets, cameras, and more. It typically consists of solar panels that capture sunlight and convert it into electricity, which is then stored in an internal battery or used to charge devices directly.",
            price: 140000,
            category: "Solar Powered Gadgets",
            stock: 7
        },
        {
            title: "Water Quality Sensor",
            description: "A water quality sensor is a device or instrument designed to measure and monitor various parameters and characteristics of water, such as its chemical composition, physical properties, and biological content. These sensors are used in a wide range of applications to assess the suitability of water for specific purposes, such as drinking, recreational activities, industrial processes, and environmental monitoring.",
            price: 175000,
            category: "Environmental Monitoring",
            stock: 17
        },
        {
            title: "Fitness Tracker Watch",
            description: "A fitness tracker watch, also known as an activity tracker or smart fitness watch, is a wearable device designed to monitor and record various aspects of a person's physical activity and health metrics. These devices are typically worn on the wrist and come equipped with a variety of sensors to track movement, heart rate, sleep patterns, and more.",
            price: 122500,
            category: "Health and Safety",
            stock: 11
        },
    ]

    const data = wearableItems.find((element) => element.title === item);

    title.innerHTML = data.title
    description.innerHTML = data.description
    price.innerHTML = `${data.price} kyats`
    category.innerHTML = data.category
    stock.innerHTML = data.stock
}