const porjectUrl = 'https://sparejo1311.ieszaidinvergeles.es/laraveles/pagination-project/public/';
const searchParamName = 'q';

let form = document.getElementById("search-form");
let searchInput = document.getElementById("search-input");

form.addEventListener('submit', (e) =>{
    // e.preventDefault();
    const urlSearchParams = new URLSearchParams(window.location.search);
    const params = Object.fromEntries(urlSearchParams.entries());
    
    params[searchParamName] = searchInput.value;
    
    let url = '/?';
    for (const param in params) {
        url += `${param}=${params[param]}&`;
    }
    
    url = url.substring(0, url.length - 1);
    
    window.location.href = porjectUrl + url;
    
    console.log(window.location.href);
})



