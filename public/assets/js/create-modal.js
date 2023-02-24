const projectURL = 'https://sparejo1311.ieszaidinvergeles.es/laraveles/ajax-pagination-project/public/'
let form = document.getElementById('createForm');
form.addEventListener("submit", async (e) =>{
    e.preventDefault();
    const formData = new FormData(e.target);
    let formDataObj = Object.fromEntries(formData.entries());
    formDataObj.images = formData.getAll('images[]');
    formDataObj.colors = formData.getAll('colors[]');
    formDataObj.tags = formData.getAll('tags[]');
    console.log(formDataObj);
    for([index, image] of formDataObj.images.entries()){
        formDataObj.images[index] = await toBase64(image);
    }
    let response = await fetch(`${projectURL}admin/product`, {
        method: "POST",
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formDataObj)
    });
    let data = await response.json();
    $('#createProductModal').modal('hide');
    if(data.success) {
        document.getElementById("admin-events").classList.remove = "alert-success";
        document.getElementById("admin-events").classList.add = "alert-danger";
        e.target.reset();
        refreshDataCreate();
    } else if(data.error) {
        document.getElementById("admin-events").classList.add = "alert-success";
        document.getElementById("admin-events").classList.remove = "alert-danger";
    }
});

const toBase64 = file => new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = error => reject(error);
});

async function refreshDataCreate(){
    let response = await fetch(`${projectURL}admin/fetchAdminProducts`);
    let data = await response.json();
    let table = document.getElementById('admin-product-table');
    let content = "";
    for(product of data.products){
        content += `
    		<tr>
    		    <td>${product.id}</td>
    			<td>${product.name}</td>
    			<td class="d-none d-xl-table-cell">${product.price} $</td>
    			<td class="d-none d-md-table-cell">${product.description}</td>
    			<td class="d-none d-md-table-cell">${product.category.name}</td>
    			<td class="d-none d-md-table-cell">${product.created_at}</td>
    		    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-type="product" data-url="${projectURL}admin/product/${product.id}" data-name="${product.name}""><i class="ti-trash mr-2" style="color:red;"></i></a></td>
    		    <td class="d-none d-md-table-cell"><a class="editButton" href="" data-toggle="modal" data-target="#editProductModal" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}" data-category="${product.category.id}" data-images='${JSON.stringify(product.images)}' data-tags='${JSON.stringify(product.tags)}' data-colors='${JSON.stringify(product.colors)}' data-url="${projectURL}admin/product/${product.id}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
    		</tr>
        `;
    }
    table.innerHTML = content;
    setUpDeleteButtonEvents();
    setUpEditButtonEvents();
}