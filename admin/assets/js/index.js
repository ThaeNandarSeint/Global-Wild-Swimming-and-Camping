// IMAGE PREVIEW
function preview(images, output = '') {
    const previewImages = document.querySelector('#preview-images')

    Array.from(images.files).map((file) => {
        const imageUrl = window.URL.createObjectURL(file)
        output += `
        <div class="image_container">
            <img src=${imageUrl} alt="">
            <div class="image_overlay">
                <div class="image_overlay_text">
                    <span style="display: none;">${file.name}</span>
                    <div class="fa-solid fa-trash" onclick="handleImageDelete(this)"></div>
                </div>
            </div>
        </div>`
    })
    previewImages.innerHTML = output
}

function handleImageDelete(element) {
    const imageInput = document.querySelector('#image-input')
    const imageName = element.previousSibling.previousSibling.innerHTML
    const fileLists = new ClipboardEvent("").clipboardData || new DataTransfer()

    Array.from(imageInput.files).map((file) => {
        if (file.name !== imageName) {
            fileLists.items.add(file)
        }
    })

    imageInput.files = fileLists.files

    const imageContainer = element.parentNode.parentNode.parentNode
    imageContainer.style.display = "none"
}

// PITCH /SWIMMING SITE DETAIL IMAGE THUMB-NAIL ONCLICK
function changeImage(element) {
    const mainImg = document.querySelector('.detail_main_image img')
    mainImg.src = element.href
}

// SELECT BOX (SEARCH-FILTER)
const selected = document.querySelector(".selected");
const optionsContainer = document.querySelector(".options_container");
const searchBox = document.querySelector(".select_search_box input");

const optionsList = document.querySelectorAll(".select_option");

selected.addEventListener("click", () => {
    optionsContainer.classList.toggle("active");

    searchBox.value = "";
    filterList("");

    if (optionsContainer.classList.contains("active")) {
        searchBox.focus();
    }
});

optionsList.forEach(o => {
    o.addEventListener("click", () => {
        selected.innerHTML = o.querySelector("label").innerHTML;
        selected.nextElementSibling.value = o.querySelector("input").value
        optionsContainer.classList.remove("active");
    });
});

function onSearch(input) {
    filterList(input.value);
}

const filterList = searchTerm => {
    searchTerm = searchTerm.toLowerCase();
    optionsList.forEach(option => {
        let label = option.firstElementChild.nextElementSibling.innerText.toLowerCase();
        if (label.indexOf(searchTerm) != -1) {
            option.style.display = "block";
        } else {
            option.style.display = "none";
        }
    });
};

// CLOSE ALERT BOX
function closeErrorMsg() {
    const messageContainer = document.querySelector('.message_container')
    messageContainer.style.display = "none"
}