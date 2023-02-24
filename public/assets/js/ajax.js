const projectURL = 'https://sparejo1311.ieszaidinvergeles.es/laraveles/ajax-pagination-project/public/'
let queryString = [];
let params = [];
window.onload = () =>{
    fetchData('fetchdata');
    setUpEvents();
};

async function fetchData(url){
    let response = await fetch(url);
    let data = await response.json();
    queryString = data.queryString;
    params = data.params;

    renderProducts(data.products.data);
    renderProductModals(data.products.data, data.urls);
    renderPagination(data.products.links);
    load_js();
}

async function fetchUtil(url, text = false, params = {}){
    let response = await fetch(url, params);
    let data = null;
    if(text){
        data = await response.text();
    }else{
        data = await response.json();
    }
    
    return data;
}

async function renderProducts(products){
    let productContainer = document.getElementById('my-product-container');
    let content = '';
    for(const product of products){
        content += `
            <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
            	<!-- Block2 -->
            	<div class="block2">
            		<div class="block2-pic hov-img0 product-img">
            			<img loading="lazy" style="object-fit:cover;height:100%;" src="${projectURL}product/display/${product.images[0].path}" alt="IMG-PRODUCT">
            			<a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04" data-toggle="modal" data-target="#product-modal-${product.id}">
            				Quick View
            			</a>
            		</div>
            
            		<div class="block2-txt flex-w flex-t p-t-14">
            			<div class="block2-txt-child1 flex-col-l ">
            				<a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            					${product.name}
            				</a>
            
            				<span class="stext-105 cl3">
            					$${product.price}
            				</span>
            			</div>
            
            			<div class="block2-txt-child2 flex-r p-t-3">
            				<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
            					<img class="icon-heart1 dis-block trans-04" src="${projectURL}assets/images/icons/icon-heart-01.png" alt="ICON">
            					<img class="icon-heart2 dis-block trans-04 ab-t-l" src="${projectURL}assets/images/icons/icon-heart-02.png" alt="ICON">
            				</a>
            			</div>
            		</div>
            	</div>
            </div>
        `;
    }
    productContainer.innerHTML = content;
}

async function renderProductModals(products, urls){
    let container = document.getElementById('product-modal-container');
    let content = '';
    let imagesContent = '';
    let tagsContent = '';
    let colorsContent = '';
    for(const product of products){
        for(const image of product.images){
            imagesContent += `
				<div class="item-slick3" data-thumb="${projectURL}product/display/${image.path}">
					<div class="wrap-pic-w pos-relative" style="height: 500px;" >
						<img style="height:100%;object-fit:cover;" src="${projectURL}product/display/${image.path}" alt="IMG-PRODUCT">

						<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${projectURL}product/display/${image.path}">
							<i class="fa fa-expand"></i>
						</a>
					</div>
				</div>
            `;
        }
        for(const mytag of product.tags){
            tagsContent += `
				<a href="${ urls.tag[mytag.name] }" class="tag-active flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
					${mytag.name}
				</a>
            `;
        }
        
        for(const color of product.colors){
            colorsContent += `
                <option>${color.name}</option>
            `;
        }
        content += `
        	<div id="product-modal-${product.id}" class="my-product-modal wrap-modal1 js-modal1 p-t-60 p-b-20">
        		<div class="overlay-modal1 js-hide-modal1"></div>
        
        		<div class="container">
        			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
        				<button type="button" class="close how-pos3 hov3 trans-04" data-dismiss="modal" aria-label="Close">
        					<img src="${projectURL}assets/images/icons/icon-close.png" alt="CLOSE">
        				</button>
        
        				<div class="row">
        					<div class="col-md-6 col-lg-7 p-b-30">
        						<div class="p-l-25 p-r-30 p-lr-0-lg">
        							<div class="wrap-slick3 flex-sb flex-w">
        								<div class="wrap-slick3-dots"></div>
        								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>
        
        								<div class="slick3 gallery-lb">
        									${imagesContent}
        								</div>
        							</div>
        						</div>
        					</div>
        					
        					<div class="col-md-6 col-lg-5 p-b-30">
        						<div class="p-r-50 p-t-5 p-lr-0-lg">
        							<div class="d-flex">
        							    ${tagsContent}
        							</div>
        							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
        								${ product.name }
        							</h4>
        
        							<span class="mtext-106 cl2">
        								$${ product.price }
        							</span>
        
        							<p class="stext-102 cl3 p-t-23">
        								${ product.description }
        							</p>
        							
        							<!--  -->
        							<div class="p-t-33">
        
        								<div class="flex-w flex-r-m p-b-10">
        									<div class="size-203 flex-c-m respon6">
        										Color
        									</div>
        									
        									<div class="size-204 respon6-next">
        										<div class="rs1-select2 bor8 bg0">
        											<select class="js-select2" name="time">
        												${colorsContent}
        											</select>
        											<div class="dropDownSelect2"></div>
        										</div>
        									</div>
        								</div>
        
        								<div class="flex-w flex-r-m p-b-10">
        									<div class="size-204 flex-w flex-m respon6-next">
        
        										<button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
        											Buy Now
        										</button>
        									</div>
        								</div>	
        							</div>
        						</div>
        					</div>
        				</div>
        			</div>
        		</div>
        	</div>
        `;
        imagesContent = '';
        tagsContent = '';
        colorsContent = '';
    }
    container.innerHTML = content;
}

function setUpEvents(){
    let search = document.getElementById('search-input');
    search.addEventListener('input', (e) => {
        let url = route('fetchdata', {
            ...queryString,
            q: e.target.value
        });
        fetchData(url);
    })
    
    let categoryContainer = document.getElementById('category-container');
    categoryContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            removeAllActives(categoryContainer.children, 'how-active1');
            e.target.classList.add('how-active1');
            let url = route('fetchdata', {
                ...queryString,
                category: e.target.dataset.value
            });
            fetchData(url);
        }
    })
    
    let sortTypeContainer = document.getElementById('sort-type-container');
    sortTypeContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            removeAllActives(sortTypeContainer.children, 'filter-link-active', true);
            e.target.classList.add('filter-link-active');
            let url = route('fetchdata', {
                ...queryString,
                sorttype: e.target.dataset.value
            });
            fetchData(url);
        }
    })
    
    let sortByContainer = document.getElementById('sort-by-container');
    sortByContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            removeAllActives(sortByContainer.children, 'filter-link-active', true);
            e.target.classList.add('filter-link-active');
            let url = route('fetchdata', {
                ...queryString,
                sortby: e.target.dataset.value
            });
            fetchData(url);
        }
    })
    
    let priceContainer = document.getElementById('price-container');
    priceContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            removeAllActives(priceContainer.children, 'filter-link-active', true);
            e.target.classList.add('filter-link-active');
            let url = route('fetchdata', {
                ...queryString,
                price: e.target.dataset.value
            });
            fetchData(url);
        }
    })
    
    let colorContainer = document.getElementById('color-container');
    colorContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            let color = e.target.dataset.value;
            let selectedLength = 1;
            if(e.target.dataset.value == 0){
                removeAllActives(colorContainer.children, 'filter-link-active', true, 1);
                e.target.classList.add('filter-link-active');
                color = '';
            }else if(params.color && params.color.selected.includes(Number(e.target.dataset.value))){
                let seletectedArray = queryString.color.split(',');
                for(const [index, element] of seletectedArray.entries()){
                    if(element == e.target.dataset.value){
                        seletectedArray.splice(index, 1);
                    }
                }
                selectedLength = seletectedArray.length; 
                color = seletectedArray.join(',');
            }else if(queryString.color){
                color = queryString.color + ',' + e.target.dataset.value;
            }
            if(e.target.dataset.value != 0){
                e.target.classList.toggle('filter-link-active');
                if(selectedLength > 0){
                    document.getElementById('all-colors').classList.remove('filter-link-active');
                }else{
                    document.getElementById('all-colors').classList.add('filter-link-active');
                }
            }else{
                e.target.classList.add('filter-link-active');
            }
            
            let url = route('fetchdata', {
                ...queryString,
                color: color
            });
            
            fetchData(url);
        }
    })
    
    let tagContainer = document.getElementById('tag-container');
    tagContainer.addEventListener('click', (e) =>{
        if(e.target.dataset.name){
            let tag = e.target.dataset.value;
            if(params.tag && params.tag.selected.includes(Number(e.target.dataset.value))){
                let seletectedArray = queryString.tag.split(',')
                for(const [index, element] of seletectedArray.entries()){
                    if(element == e.target.dataset.value){
                        seletectedArray.splice(index, 1);
                    }
                }
                tag = seletectedArray.join(',');
            }else if(queryString.tag){
                tag = queryString.tag + ',' + e.target.dataset.value;
            }
            e.target.classList.toggle('tag-active');
            
            let url = route('fetchdata', {
                ...queryString,
                tag: tag
            });
            fetchData(url);
        }
    })
}

function renderPagination(links){
    // Pagination
    let paginationDiv = document.getElementById('pagination-container');
    let string = '';
    links.forEach(pag => {
        if (pag.active) {
            string += `
                <li class="page-item active" aria-current="page">
                    <span class="page-link clickable" data-url="${pag.url}">${pag.label}</span>
                </li>
            `;
        } else if (pag.url != null) {
            string += `
                <li class="page-item">
                    <span class="btn btn-link clickable" data-url="${pag.url}" id="${'pag' + pag.label}">${pag.label}</span>
                </li>
            `;
        } else {
            string += `
                <li class="page-item disabled">
                    <span class="page-link" data-url="${pag.url}" aria-hidden="true">${pag.label}</span>
                </li>
            `;
        }
    });
    paginationDiv.innerHTML = string;
    addPaginationFunctionality();
}

function addPaginationFunctionality() {
    let pagination = document.getElementById('pagination-container');
    pagination.addEventListener('click', handleClick);
}

function handleClick(e){
    if(e.target.classList.contains('clickable')){
        fetchData(e.target.dataset.url);
    }
}

function removeAllActives(elements, className, anchorInside = false, anchorIndex = 0){
    for(const element of elements){
        if(anchorInside && element.children[anchorIndex]){
            element.children[anchorIndex].classList.remove(className);
        }else{
            element.classList.remove(className);
        }
    }
}

function route(route, params){
    let query = '';
    for(const param in params){
        if(params[param]){
            query += `${param}=${params[param]}&`;
        }
    }
    return `${route}?${query}`;
}

function load_js() {
  let slick = document.getElementById("slick-custom");
  let newSlick = document.createElement('script');
  newSlick.src = `${projectURL}/assets/js/slick-custom.js`
  newSlick.id ='slick-custom';
  document.body.removeChild(slick);
  document.body.appendChild(newSlick);
}