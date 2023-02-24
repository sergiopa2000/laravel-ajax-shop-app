setUpEditButtonEvents();
function setUpEditButtonEvents(){
    let editButtons = document.querySelectorAll('.editButton');
    for (const button of editButtons) {
        // console.log(button.dataset);
        let url = button.dataset.url;
        let name = button.dataset.name;
        let price = button.dataset.price;
        let desc = button.dataset.description;
        let category = button.dataset.category;
        let tags = JSON.parse(button.dataset.tags);
        let colors = JSON.parse(button.dataset.colors);
        button.addEventListener("click", (e) =>{
            // console.log(e.target);
            setInputValue("edit-name", name);
            setInputValue("edit-price", price);
            setInputValue("edit-description", desc);
            console.log(`name: ${name}`)
            document.getElementById(`edit-category-${category}`).selected = true;


            // console.log(url);
            // document.getElementById("deleteForm").action = url;
            // document.querySelector("#deleteForm p").innerHTML = `Are you sure you want to delete ${type} ${name}?`;
        })
    }
}

function setInputValue(input, value){
    document.getElementById(input).value = value;
}