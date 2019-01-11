var itemsRequest = new XMLHttpRequest();
var list = [];
itemsRequest.open('GET' , 'http://localhost/justcook/api/read/itemCategoryRead.php',true);

itemsRequest.onload = function() {
    var data = JSON.parse(this.response);
    if(itemsRequest.status >= 200 && itemsRequest.status < 400) {
        data.items_category.forEach(items => {
            const list = document.getElementById("search-unordered-list");
            const li = document.createElement('li');
            li.setAttribute('id',items.itemsCategoryId + "li");
        
            const buttons = document.createElement('button');
            buttons.setAttribute('class' , 'collapsible');
            buttons.setAttribute('id', items.itemsCategoryId);
            buttons.style.fontFamily = 'Advent Pro';
            buttons.innerHTML= items.itemsName;
            buttons.onclick = function() {itemsCategory(this.id)};

            li.appendChild(buttons);
            list.appendChild(li);

        });
    }
}

itemsRequest.send();

function itemsCategory(id){
    var categoryItems = new XMLHttpRequest();
    console.log(id);
    categoryItems.open('POST','http://localhost/justcook/api/read/itemRead.php',true);
    categoryItems.setRequestHeader("Content-type", "application/json; charset=UTF-8");
    var string  = {'itemsCategoryId': id};
    var data = JSON.stringify(string);
    categoryItems.send(data);
    
    categoryItems.onload = function() {
        var data =JSON.parse(this.response);

        const li = document.getElementById(id+"li");

        const content = document.createElement('div');
        content.setAttribute('class' , 'content');

        if(categoryItems.status >= 200 && categoryItems.status < 400){
            data.items.forEach(items => {
                const checkboxs = document.createElement('div');
                checkboxs.setAttribute('class', 'checkboxs');

                const input = document.createElement('input');
                input.setAttribute('type','checkbox');
                input.setAttribute('name', items.itemName);
                input.setAttribute('value',items.itemName);
                input.setAttribute('id',items.itemId);
                input.addEventListener("click", function(){
                    if(input.checked){
                        list.push(input.value);
                    }else{
                        list.pop(input.value);
                    }
                });
                
                const label = document.createElement('label');
                label.textContent=items.itemName;
                label.style.fontSize = '25px';
                label.style.paddingLeft = '10px';
                label.style.paddingRight = '10px';
                label.style.display = 'inline-block';

                const img = document.createElement('img');
                img.setAttribute('src', items.itemsUrl);

                checkboxs.appendChild(input);
                checkboxs.appendChild(label);
                checkboxs.appendChild(img);

                content.appendChild(checkboxs); 
            });
        }
        li.appendChild(content);
    }

    var coll = document.getElementsByClassName("collapsible");
    var i;
    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                content.style.display = "block";
            }
        
        });
    } 
}

function search(){
    console.log(list.join(" "));
    window.open('http://localhost/justcook/recipeslist.html?qtype=2&list=' + list.join(","), "_self");
}