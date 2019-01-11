var lists = new XMLHttpRequest();
lists.open('POST', 'http://localhost/justcook/api/read/recipesRead.php',true);
lists.setRequestHeader("Content-type", "application/json; charset=UTF-8");
    
const urlParams = new URLSearchParams(window.location.search);
const qtype = urlParams.get('qtype');
    
if(qtype == 1){
    openUsingCat(urlParams ,lists);
}else{
    openUsingList(urlParams ,lists);
}

function openUsingList(urlParams){
    const lt = urlParams.get('list');
    var string = {'categorySerach' : ""};
    var data = JSON.stringify(string);
    lists.send(data);
    const head = document.getElementById('head');
    head.textContent = "Search - specific recipes with items : " + lt;
    
    lists.onload = function(){
        console.log(this.response);
        var data = JSON.parse(this.response);
        const list = document.getElementById('list-content-divs');
        
        if(lists.status >= 200 && lists.status < 400){
            data.recipes.forEach(recipe => {
                if(search(recipe.recipesIngridents, lt)){
                    console.log(" this is included : " + recipe.recipesId);
                    createHtmls(recipe,list);
                }else{
                    console.log("this is not included : " + recipe.recipesId);
                }
            });
        } else {
            displayError(list);
        }
    }

}

function search(retrivedData , selectedData){
    var flag = false;
    var selectedDataArr = selectedData.split(",");
    var retrivedDataArr = retrivedData.split(",");
    for (var i = 0; i < selectedDataArr.length; i++) {
        for (var j = 0; j < retrivedDataArr.length; j++) {
            if (selectedDataArr[i] === retrivedDataArr[j]) {
                flag = true;
            }
        }
    }
    return flag;
}

function openUsingCat(urlParams){
   
    const categorySearch = urlParams.get('cat_id');
    const categorySearchName = urlParams.get('cat_search');
    var string  = {'categorySearch' : categorySearch};
    var data = JSON.stringify(string);
    lists.send(data);
    
    const head = document.getElementById('head');
    head.textContent = "Search - " + categorySearchName;
    
    lists.onload = function(){
        var data = JSON.parse(this.response);
        const list = document.getElementById('list-content-divs');
        
        if(lists.status >= 200 && lists.status < 400){
            data.recipes.forEach(recipe => {
                createHtmls(recipe,list);
            });
        } else {
            displayError(list);
        }
    }
    
}

function openError(){
    console.log("Error");
}

function displayError(list){
    const errorMessage = document.createElement('marquee');
    errorMessage.textContent = `Gah, it's not working!`;
    list.appendChild(errorMessage);
}

function createHtmls(recipe, list){
    const listItem = document.createElement('div');
    listItem.setAttribute('class','list-item animate-bottom');
    
    const image = document.createElement('div');
    image.setAttribute('class', 'img');

    const img = document.createElement('img');
    img.setAttribute('src',recipe.recipesImageUrl);
    img.style.height = '270px';
    img.style.width = '270px';
                
    const content = document.createElement('div');
    content.setAttribute('class' , 'item-content');
    
    const h2 = document.createElement('h2');
    h2.textContent = recipe.recipesName;
    
    const p = document.createElement('p');
    p.style.fontSize = '21px';
    p.textContent = (recipe.recipesDetail).substring(0, 270) + " . . . . . . .";
    
    const more = document.createElement('div');
    more.setAttribute('class','down-content');
    
    const a = document.createElement('a');
    a.setAttribute('id' , recipe.recipesId);
    a.setAttribute('onClick', 'openListDetail(this.id)');
    a.textContent = "continue reading...";
    a.style.fontSize = '28px';
                
    more.appendChild(a);
    
    content.appendChild(h2);
    content.appendChild(p);
    content.appendChild(more);
                
    image.appendChild(img);
                
    listItem.appendChild(image);
    listItem.appendChild(content);
                
    list.appendChild(listItem);
}

function openListDetail(id){
   
    window.open('http://localhost/justcook/recipeDetail.html?rep_id=" '+id+' "' , "_self");
}
