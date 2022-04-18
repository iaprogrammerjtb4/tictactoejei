<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Game</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <div v-if="config" id="options-game">
            <h1>Seleccione valores para el juego: </h1>
            <input v-model="playerOneV" placeholder="ingrese nombre jugador" type="text" id="player-name">
            <label for="">Seleccione figura:</label>
            <select v-on:change="config=false" v-model="figure" name="figure" id="">                
                <option value="cuadrado">cuadrado</option>
                <option value="triangulo">triangulo</option>
            </select>
        </div>
        <div v-else>
            <h1>a jugar!</h1>
        </div>            
        <section>
            <h1 class="game-title">{{name}}</h1>
            <span>{{ playerOneV }} vs {{ rival }}</span>
            <div class="game">                
                <div v-for="g in game" v-on:click="clickUser(g.position)" :data-cell-index="g.position" :key="g.id" class="cell">
                    <div v-if="g.figure=='cuadrado'">
                        <img width="30" height="30" src="https://w7.pngwing.com/pngs/560/434/png-transparent-purple-frame-illustration-square-computer-icons-shape-purple-angle-text-thumbnail.png"/>                                        
                    </div>
                    <div v-if="g.figure =='triangulo'">
                        <img width="30" height="30" src="https://png.pngtree.com/png-clipart/20190515/original/pngtree-triangle-border-png-image_3551805.jpg"/>                        
                    </div>                    
            </div>                
            </div>
            <h2 class="game--status"></h2>
            <button v-if="onGame" class="game--restart">Restart Game</button>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>    
        <script>
            const app = new Vue({
            el: '#app',   
            mounted(){
                this.clickUser('newGame')
            },
            data(){
                return{
                    config:true,
                    idGame:0,
                    figure:'Seleccione figura',
                    onGame:false,
                    rival:'jei',
                    name:'TICTACTOE-JEI',
                    game:[
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "A1",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "A2",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "A3",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "B1",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "B2",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "B3",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "C1",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "C2",
                        },
                        {
                            "figure":"",
                            "game":2,                            
                            "player": "",
                            "position": "C3",
                        }                    
                    ],
                    game_firebase:[],
                    url:'http://127.0.0.1:8000/api/',
                    playerOneV:'Jugador 1',                                        
                }
            },
            methods: {
                validPositions(arrFire){
                    if(Array.isArray(arrFire)){
                        this.game.forEach(function(currentValue,index,array){
                            arrFire.forEach(function(val,ind,arr){                            
                                if(val.position == currentValue.position){
                                    currentValue.player = val.player;                     
                                    currentValue.figure = val.figure
                                }
                            });                            
                        });
                    }else{

                    }                    
                },
                loadGame(response){     
                    if(this.idGame == 0){
                        this.idGame = response.data;
                    }
                    console.log(response.data);                   
                    var data = {
                        game: this.idGame,
                        playerOne:this.playerOneV,
                        player:this.playerOneV,                        
                    };
                    var path = this.url+'game/'+this.idGame;
                    fetch(path, {
                    method: 'GET',                  
                    headers:{
                        'Content-Type': 'application/json'
                    }
                    }).then(res => res.json())
                    .catch(error => console.error('Error:', error))
                    .then(response => (this.validPositions(response.data)));
                
                },
                clickUser(mov){                                      
                    var data = {
                        game: this.idGame,
                        player:this.playerOneV,                        
                        position:mov,
                        figure:this.figure
                    };
                    var path = this.url+'new-game';
                    fetch(path, {
                    method: 'POST', // or 'PUT'
                    body: JSON.stringify(data), // data can be `string` or {object}!
                    headers:{
                        'Content-Type': 'application/json'
                    }
                    }).then(res => res.json())
                    .catch(error => console.error('Error:', error))
                    .then(response =>this.loadGame(response));
                }
            },

        });
    </script>
</body>
</html>