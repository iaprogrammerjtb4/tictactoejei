<template>
    <div class="container">
        <h1>{{ name }}</h1>
    </div>
</template>
<script>
    export default {
        name:'home-game',
        data(){
            return {
                tiros:[
                    {
                        id:1,
                        position:"A3",
                        player:1,
                        figure:'cuadrado'
                    },
                    {
                        id:2,
                        position:"B3",
                        player:2,
                        figure:'rectangulo'
                    }
                ],
                name:'TIC-TAC-TOE = JEI'
            };
        },
        created() {
            console.log('listones');
        },
    }
</script>