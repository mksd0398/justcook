var barRequest = new XMLHttpRequest();
barRequest.open('GET', 'http://localhost/justcook/api/read/categoryRead.php', true);
barRequest.onload = function () {
    var data = JSON.parse(this.response);
    const bars = document.getElementById('divs');
    if (barRequest.status >= 200 && barRequest.status < 400) {
        data.categories.forEach(categorie => {
            
            const card = document.createElement('div');
            console.log(categorie.categoryImageUrl);
            card.style.background = "linear-gradient(180deg, rgba(0,0,0, 0.1), rgba(0,0,0, 0.9)),url('"+categorie.categoryImageUrl+"')";
            card.style.backgroundSize = "cover";
            card.setAttribute('class', 'sliding-menu-frame');
            card.style.marginRight="6px";
    
            const a = document.createElement('a');
            a.setAttribute('id' , categorie.categoryId);
            a.setAttribute('name' , categorie.name);
            a.setAttribute('class', 'post-title');
            a.setAttribute('onClick', 'openList(this.id, this.name)');
                
            const h4 = document.createElement('h4');
            h4.textContent = categorie.name;
    
            a.appendChild(h4);
                
            card.appendChild(a);
    
            bars.appendChild(card);
        });
    } else {
        const errorMessage = document.createElement('marquee');
        errorMessage.textContent = `Gah, it's not working!`;
        data.appendChild(errorMessage);
    }
}
// Send Request
barRequest.send();

function openList(id , name){
    window.open(`http://localhost/justcook/recipeslist.html?qtype=1&cat_id="${id}"&cat_search="${name}"` , "_self");
}