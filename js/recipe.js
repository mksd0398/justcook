var lists = new XMLHttpRequest();
lists.open('POST', 'http://localhost/justcook/api/read/recipesDetailRead.php',true);
lists.setRequestHeader("Content-type", "application/json; charset=UTF-8");

const urlParams = new URLSearchParams(window.location.search);
const repId = urlParams.get('rep_id');
var string  = {'recipeId' : repId};
var data = JSON.stringify(string);
lists.send(data);

lists.onload = function(){
    var data = JSON.parse(this.response);
    const list = document.getElementById('list-content-divs');
    if(lists.status >= 200 && lists.status < 400){
        data.recipes.forEach(recipe => {
            const name = document.getElementById('recipeName');
            name.textContent = recipe.recipesName;

            const time  = document.getElementById('time');
            time.textContent = "Time Taken: "+ recipe.timeTaken;

            const image = document.getElementById('recipeImg');
            image.setAttribute('src', recipe.recipesImageUrl);

            const ingredientList = document.getElementById('ingredientsList');
            var res = (recipe.recipesIngridents).split(",");
            res.forEach(rep => {
    	        const li = document.createElement('li');
                li.textContent = rep;
                ingredientList.appendChild(li);
            });
            const details = document.getElementById('detailsContent');
            details.textContent = recipe.recipesDetail;
        });
    } else {
        const errorMessage = document.createElement('marquee');
        errorMessage.textContent = `Gah, it's not working!`;
        list.appendChild(errorMessage);
    }
}

