let buttons = document.querySelectorAll('.my-show-modal');
for(button of buttons){
    let mybutton = button;
    mybutton.addEventListener('click', (e) =>{
        e.preventDefault();
        let product = JSON.parse(mybutton.dataset.product);
        let images = JSON.parse(mybutton.dataset.images);
        let colors = JSON.parse(mybutton.dataset.colors);
        let tags = JSON.parse(mybutton.dataset.tags);
        
        updateModal(product, images, colors, tags);
        let modal = document.getElementById('product-modal');
        modal.classList.add('show-modal1')
    });
}


async function updateModal(product, images, colors, tags){
    let gallery = document.getElementById('product-gallery');
    let galleryLeft = document.querySelector('.slick3-dots');
    console.log(galleryLeft);
    for(image of images){
        let response = await fetch(`product/display/${image.path}`);
        gallery.innerHTML += `<div class="item-slick3" data-thumb=${response.url}>
            					<div class="wrap-pic-w pos-relative">
            						<img src=${response.url} alt="IMG-PRODUCT">
            
            						<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${response.url}">
            							<i class="fa fa-expand"></i>
            						</a>
            					</div>
            				</div>`
        galleryLeft.innerHTML += `
                <li class="" role="presentation">
                    <img src=${response.url}>
                    <div class="slick3-dot-overlay"></div>
                </li>
        `
    }
}