let colors = document.querySelectorAll(".color-input-container");
for(color of colors){
    let mycolor = color;
    let colorClass = color.dataset.class;
    color.addEventListener('click', () => {
        mycolor.classList.toggle(colorClass);
        let object = JSON.parse(mycolor.childNodes[1].value);
        if(object.value == 0){
            object.value = 1;
            mycolor.childNodes[1].value = JSON.stringify(object);
        }else{
            object.value = 0;
            mycolor.childNodes[1].value = JSON.stringify(object);
        }
        
    });
}