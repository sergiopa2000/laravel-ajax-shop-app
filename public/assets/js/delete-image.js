
let buttons = document.querySelectorAll(".deleteImageButton")
console.log(buttons)
for (button of buttons) {
  let url = button.dataset.url;
  button.addEventListener("click", (e) =>{
    let form = document.getElementById("deleteImageForm");
    form.action = url;
    form.submit();
});
}