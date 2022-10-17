//variables
const football = document.getElementById("Football");
const ligue1 = document.getElementById("Ligue 1");
const ligueChamp = document.getElementById("LigueChamp");
const coupe = document.getElementById("Coupe");
const searchBtn = document.getElementById("searchBtn");

const newsQuery = document.getElementById("newsQuery");
const newsType = document.getElementById("newsType");
const newsdetails = document.getElementById("newsdetails");

//array
var newsDataArr = [];

//apis
const API_KEY = "db212197e79b4540a0c56a86362bd5c7";
const FOOTBALL_NEWS = "https://newsapi.org/v2/top-headlines?q=football&apiKey=";
const LIGUE1_NEWS = "https://newsapi.org/v2/everything?q=ligue1&apiKey=";
const LIGUECHAMP_NEWS = "https://newsapi.org/v2/everything?q=championleague&apiKey=";
const COUPE_NEWS = "https://newsapi.org/v2/everything?q=worldcup&apiKey=";

const SEARCH_NEWS = "https://newsapi.org/v2/everything?q=";




football.addEventListener("click", function(){
    newsType.innerHTML ="<h4>Football</h4>"
    fetchFootballNews();
});

ligue1.addEventListener("click", function(){
    newsType.innerHTML ="<h4>Ligue 1</h4>"
    fetchLigue1News();

});
ligueChamp.addEventListener("click", function(){
    newsType.innerHTML ="<h4>Ligue des champions</h4>"
    fetchLigueChampNews();

});
coupe.addEventListener("click", function(){
    newsType.innerHTML ="<h4>Coupe du monde</h4>"
    fetchCoupeNews();

});

searchBtn.addEventListener ("click", function(){
    newsType.innerHTML ="<h4>Rechercher : "+newsQuery.value+"</h4>"
    fetchQueryNews();

});


const fetchFootballNews = async () => {
    const response = await fetch(FOOTBALL_NEWS+API_KEY);
    newsDataArr = [];
    if (response.status >=200 && response.status <300){
        const myJson = await response.json();
        newsDataArr = myJson.articles;
    }else{
        console.log(response.status, response.statusText);
        newsdetails.innerHTML = "<h5>Aucun résultat.</h5>";
        return;
    }

    displayNews();
}

const fetchLigue1News = async () => {
    const response = await fetch(LIGUE1_NEWS+API_KEY);
    newsDataArr = [];
    if (response.status >=200 && response.status <300){
        const myJson = await response.json();
        newsDataArr = myJson.articles;
    }else{
        console.log(response.status, response.statusText);
        newsdetails.innerHTML = "<h5>Aucun résultat.</h5>";
        return;
    }

    displayNews();
}
const fetchLigueChampNews = async () => {
    const response = await fetch(LIGUECHAMP_NEWS+API_KEY);
    newsDataArr = [];
    if (response.status >=200 && response.status <300){
        const myJson = await response.json();
        newsDataArr = myJson.articles;
    }else{
        console.log(response.status, response.statusText);
        newsdetails.innerHTML = "<h5>Aucun résultat.</h5>";
        return;
    }

    displayNews();
}
const fetchCoupeNews = async () => {
    const response = await fetch(COUPE_NEWS+API_KEY);
    newsDataArr = [];
    if (response.status >=200 && response.status <300){
        const myJson = await response.json();
        console.log(myJson);
        newsDataArr = myJson.articles;
    }else{
        console.log(response.status, response.statusText);
        newsdetails.innerHTML = "<h5>Aucun résultat.</h5>";
        return;
    }

    displayNews();
}

const fetchQueryNews = async () => {

    if (newsQuery.value == null){
        return;
    }    


    const response = await fetch(SEARCH_NEWS+encodeURIComponent(newsQuery.value)+"&apiKey="+API_KEY);
    newsDataArr = [];
    if (response.status >=200 && response.status <300){
        const myJson = await response.json();
        console.log(myJson);
        newsDataArr = myJson.articles;
    }else{
        //handle errors
        console.log(response.status, response.statusText);

    }

    displayNews();
}

function displayNews(){

    newsdetails.innerHTML = "";

    if (newsDataArr.length == 0){
        newsdetails.innerHTML = "<h5>Aucun résultat trouvé.</h5>"
        return;
    }


    newsDataArr.forEach(news => {

        var date = news.publishedAt.split("T");

        var col = document.createElement('div');
        col.className="col-sm-12 col-md-4 col-lg-3 p-2 card";

        var card = document.createElement('div');
        card.className = "p-2";

        var image = document.createElement('img');
        image.setAttribute("height","matchparent");
        image.setAttribute("width","100%");
        image.src=news.urlToImage;

        var cardBody = document.createElement('div');

        var newsHeading = document.createElement('h5');
        newsHeading.className = "card-title";
        newsHeading.innerHTML = news.title;

        var dateHeading = document.createElement('h6');
        dateHeading.className = "text-primary";
        dateHeading.innerHTML = date[0];

        var description = document.createElement('p');
        description.className = "text-muted";
        description.innerHTML = news.description;

        var link = document.createElement('a');
        link.className = "btn bn-dark";
        link.setAttribute("target", "_blank");
        link.href = news.url;
        link.innerHTML="Read more";

        cardBody.appendChild(newsHeading);
        cardBody.appendChild(dateHeading);
        cardBody.appendChild(description);
        cardBody.appendChild(link);

        card.appendChild(image);
        card.appendChild(cardBody);

        col.appendChild(card);

        newsdetails.appendChild(col);
    });


}