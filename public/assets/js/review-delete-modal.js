setUpDeleteButtonEvents();

document.getElementById("deleteForm").addEventListener('submit', async (e) =>{
    e.preventDefault();
    let response = await fetch(e.target.action, {
        method: 'DELETE',
        headers:{
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    });
    let data = await response.json();
    $('#deleteModal').modal('hide');
    if(data.success) {
        document.getElementById("admin-events").classList.remove = "alert-success";
        document.getElementById("admin-events").classList.add = "alert-danger";
        await refreshDataDelete();
    } else if(data.error) {
        document.getElementById("admin-events").classList.add = "alert-success";
        document.getElementById("admin-events").classList.remove = "alert-danger";
    }
})

async function refreshDataDelete(){
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
    		    <td class="d-none d-md-table-cell"><a class="deleteButton" href="" data-toggle="modal" data-target="#deleteModal" data-type="product" data-url="${projectURL}admin/product/${product.id}" data-name="${product.name}"><i class="ti-trash mr-2" style="color:red;"></i></a></td>
    		    <td class="d-none d-md-table-cell"><a class="editButton" href="" data-toggle="modal" data-target="#editProductModal" data-name="${product.name}" data-description="${product.description}" data-price="${product.price}" data-category="${product.category.id}" data-images='${JSON.stringify(product.images)}' data-tags='${JSON.stringify(product.tags)}' data-colors='${JSON.stringify(product.colors)}' data-url="${projectURL}admin/product/${product.id}"><i class="ti-pencil mr-2" style="color:green;"></i></a></td>
    		</tr>
        `;
    }
    table.innerHTML = content;
    setUpDeleteButtonEvents();
    setUpEditButtonEvents();
}

function setUpDeleteButtonEvents(){
    let deleteButtons = document.querySelectorAll('.deleteButton');
    
    for (const button of deleteButtons) {
        let url = button.dataset.url;
        let name = button.dataset.name;
        let type = button.dataset.type;
        button.addEventListener("click", () =>{
            console.log(url);
            document.getElementById("deleteForm").action = url;
            document.querySelector("#deleteForm p").innerHTML = `Are you sure you want to delete ${type} ${name}?`;
        })
    }
}