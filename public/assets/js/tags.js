let tags = document.querySelectorAll(".tag-input-container");
for(tag of tags){
    let mytag = tag;
    tag.addEventListener('click', () => {
        mytag.classList.toggle('tag-active');
        let object = JSON.parse(mytag.childNodes[1].value);
        if(object.value == 0){
            object.value = 1;
            mytag.childNodes[1].value = JSON.stringify(object);
        }else{
            object.value = 0;
            mytag.childNodes[1].value = JSON.stringify(object);
        }
    });
}