<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>TICTACTOE-JEI</title>
</head>
<body>
    <div class="container text-center" id="app">        
        <div class="row mt-3">
            <span class="col-12">
                <p class="h1">{{ name }}</p>
            </span>
        </div>
        <div class="row mt-5">
            <div class="col-6 mt-5">
                <span v-on:click="goToNewGame()" id="new-game">Nueva partida</span>
            </div>
            <div class="col-6 mt-5">
                <span id="enter-game">Ingresar ID
                    <input type="text" v-model="id" name="" id="">
                    <button v-on:click="goToGame()" >Ir a sala</button>
                </span>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>    
    <script>
        const app = new Vue({
        el: '#app',   
        data(){
            return{
                name:'TICTACTOE-JEI',
                id:0
            }
        },
        methods: {
            goToNewGame(){
                window.location.href = "/new-game";
            },
            goToGame(){
                window.location.href = "/game?id="+this.id;
            }
        },

    });
    </script>    
</body>
</html>